<?php

include_once '../app/jwt/JWTParams.php';
include_once '../app/jwt/BeforeValidException.php';
include_once '../app/jwt/ExpiredException.php';
include_once '../app/jwt/SignatureInvalidException.php';
include_once '../app/jwt/JWT.php';

use \Firebase\JWT\JWT;

class UserController extends Controller
{
    private function getHeaders()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function checkJWT($jwt)
    {
        if (empty($jwt)) {
            http_response_code(401); // unauthorized
            echo json_encode(array("message" => "Authentication failed"));
            exit();
        }

        try {
            $decodedJWT = JWT::decode($jwt, JWT_KEY, array('HS256'));
        } catch (Exception $exception) {
            http_response_code(401); // unauthorized
            echo json_encode(array("message" => $exception->getMessage()));
            exit();
        }
    }

    public function createUser()
    {
        $this->getHeaders();
        $data = json_decode(file_get_contents("php://input"));

        $this->checkJWT($data->jwt);

        if (empty($data->email)) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Unable to create user. You didn't provide email."));
        } else if (empty($data->username)) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Unable to create user. You didn't provide username."));
        } else if (empty($data->password)) {
            http_response_code(400); // bad request
            echo json_encode(array("message" => "Unable to create user. You didn't provide password."));
        } else {
            $userModel = $this->model('User');
            $result = $userModel->getUserByEmail($data->email);
            if (!empty($result)) {
                http_response_code(409); // conflict
                echo json_encode(array("message" => "Another user with same email address already exists."));
            } else {
                $password = password_hash($data->password, PASSWORD_BCRYPT);
                $result = $userModel->createUser($data->email, $data->username, $password);

                if ($result == 0) {
                    http_response_code(201); // created
                    echo json_encode(array("message" => "User created"));
                } else {
                    http_response_code(504); //  gateway timeout
                    echo json_encode(array("message" => "Unable to create user"));
                }
            }
        }
    }

    private function checkPassword($user, $password)
    {
        if (password_verify($password, $user["password"])) {
            $token = array(
                "iss" => JWT_ISS,
                "aud" => JWT_AUD,
                "iat" => JWT_IAT,
                "exp" => JWT_EXP,
                "data" => array(
                    "id" => $user["id"],
                    "email" => $user["email"],
                    "username" => $user["username"]
                )
            );

            $jwt = JWT::encode($token, JWT_KEY);
            http_response_code(200); // ok
            echo json_encode(["jwt" => $jwt]);
        } else {
            http_response_code(401); // unauthorized
            echo json_encode(array("message" => "Bad password."));
        }
    }

    public function authenticate()
    {
        $this->getHeaders();
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->email)) {
            http_response_code(401); // unauthorized
            echo json_encode(array("message" => "Unable to authenticate. You didn't provide email."));
        } else if (empty($data->password)) {
            http_response_code(401); // unauthorized
            echo json_encode(array("message" => "Unable to authenticate. You didn't provide password."));
        } else {
            $userModel = $this->model('User');
            $result = $userModel->getUserByEmail($data->email);

            if (!empty($result)) {
                $user = array(
                    "id" => $result['id'],
                    "username" => $result['username'],
                    "email" => $result['email'],
                    "password" => $result['password']
                );

                $this->checkPassword($user, $data->password);
            } else {
                http_response_code(401); // unauthorized
                echo json_encode(array("message" => "Unable to authenticate. Invalid email."));
            }
        }
    }
}
