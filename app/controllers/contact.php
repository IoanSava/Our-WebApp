<?php
session_start();

class Contact extends Controller
{
    public function index()
    {
        $name = $_POST['user_name'];
        $email = $_POST['user_mail'];
        $phone = $_POST['user_phone'];
        $message = $_POST['user_message'];

        $formManager = $this->model('FormManager');

        $verification_message = call_user_func(
            [$formManager, 'send_mail_with_info'],
            ['name' => $name, 'email' => $email, 'phone' => $phone, 'msg' => $message]
        );
        $_SESSION['verification_message'] = $verification_message;

        if (strcmp($verification_message, "It is done") != 0) {
            header('Location: ./contact/failure', TRUE, 302);
            die();
        } else {
            header('Location: ./contact/success', TRUE, 302);
            die();
        }
    }

    public function success()
    {
        $this->php_view('contact_success');
    }

    public function failure()
    {
        $this->php_view('contact_failure', ['message' => $_SESSION['verification_message']]);
    }
}
