<?php
class FormManager
{

    public function send_mail_with_info($data)
    {
        switch ($this->validateData($data)) {
            case 1:
                return "All fields are required!";
            case 2:
                return "A valid name is required: a surname and last name!";
            case 3:
                return "A valid email is required: ex@abc.xyz !";
            case 4:
                return "A valid phone number is required: xxxx-xxx-xxx !";
            case 0:
                $email_from = trim($data['email']);
                $email_subject = "Message from User";
                $email_body = "Ms./Mrs./Mr." . trim($data['name']) . " has sent the following message: '" . trim($data['msg']) . "'.\r\n"
                    . "Their contact info is:\r\n\tPhone number: " . trim($data['phone']) . ";\r\n\tEmail: {$email_from}.\r\n";
                $to = "cdc_bmi@murika.com";
                $headers = "From: {$email_from} \r\n" . "Reply-To: {$email_from} \r\n" . 'X-Mailer: PHP/' . phpversion();

                mail($to, $email_subject, $email_body, $headers);
                return "It is done";
        }
    }

    public function validateData($data)
    {
        if (empty($data['name']) || empty($data['email']) || empty($data['phone']) || empty($data['msg'])) {
            return 1;
        } elseif (preg_match('/^([A-Z][a-z]+\ [A-Z][a-z]+)$/', trim($data['name'])) == 0) {
            return 2;
        } elseif (preg_match('/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/', trim($data['email'])) == 0) {
            return 3;
        } elseif (preg_match('/^([0-9]{4}\-[0-9]{3}\-[0-9]{3})$/', trim($data['phone'])) == 0) {
            return 4;
        } else {
            return 0;
        }
    }
}
