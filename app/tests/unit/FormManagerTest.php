<?php

require_once '../tests/../app/models/FormManager.php';

final class FormManagerTest extends \PHPUnit\Framework\TestCase
{
    public function testSendMailWithInfoEmptyField(){
        $formManager = new FormManager();
        $data = ['name' => 'Alec Monroe', 'email' => 'alec.monroe@yahoo.com', 'msg' => 'I enjoy!'];
        $result = $formManager->send_mail_with_info($data);
        $this->assertSame('All fields are required!', $result);
    }

    public function testSendMailWithInfoInvalidName(){
        $formManager = new FormManager();
        $data = ['name' => 'Ale69 !Monroe', 'email' => 'alec.monroe@yahoo.com','phone' => '0743-126-111' , 'msg' => 'I enjoy!'];
        $result = $formManager->send_mail_with_info($data);
        $this->assertSame('A valid name is required: a surname and last name!', $result);
    }

    public function testSendMailWithInfoInvalidEmail(){
        $formManager = new FormManager();
        $data = ['name' => 'Alec Monroe', 'email' => 'alec.monroe?!@yahoo.com','phone' => '0743-126-111' , 'msg' => 'I enjoy!'];
        $result = $formManager->send_mail_with_info($data);
        $this->assertSame('A valid email is required: ex@abc.xyz !', $result);
    }

    public function testSendMailWithInfoInvalidPhoneNumber(){
        $formManager = new FormManager();
        $data = ['name' => 'Alec Monroe', 'email' => 'alec.monroe@yahoo.com','phone' => '0743126111' , 'msg' => 'I enjoy!'];
        $result = $formManager->send_mail_with_info($data);
        $this->assertSame('A valid phone number is required: xxxx-xxx-xxx !', $result);
    }

    public function testSendMailWithInfoDataIsValid(){
        $formManager = new FormManager();
        $data = ['name' => 'Alec Monroe', 'email' => 'alec.monroe@yahoo.com','phone' => '0743-126-111' , 'msg' => 'I enjoy!'];
        $result = $formManager->send_mail_with_info($data);
        $this->assertSame('It is done', $result);
    }
}
