<?php

require_once '../tests/../app/models/User.php';

final class UserTest extends \PHPUnit\Framework\TestCase
{
    public function test1GetUserByEmail()
    {
        $user = new User();
        $result = $user->getUserByEmail("admin@gmail.com");
        $this->assertSame(4, count($result));
    }

    public function test2GetUserByEmail()
    {
        $user = new User();
        $result = $user->getUserByEmail("someone@gmail.com");
        $this->assertFalse($result);
    }

    /* creates an user and verify if it was successfully done*/
    /*public function test1CreateUser()
    {
        $user = new User();
        $result = $user->createUser("admin1@gmail.com", "admin1", "admin1");
        $this->assertSame(0, $result);
    }

    */
}