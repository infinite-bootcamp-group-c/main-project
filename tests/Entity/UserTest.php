<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    /**
     * @return User
     */
    public function testCreateUser(): User
    {
        $user = new User();
        $this->assertNotNull($user);
        return $user;
    }

    /**
     * @param User $user
     * @return User
     * @depends testCreateUser
     */
    public function testFirstName(User $user): User
    {
        $user->setFirstName("User_FirstName");
        $this->assertSame("User_FirstName",$user->geFirstName());
        return $user;
    }

    /**
     * @param User $user
     * @return User
     * @depends testFirstName
     */
    public function testLastName(User $user): User
    {
        $user->setLastName("User_LastName");
        $this->assertsame("User_LastName",$user->LastName());
        return $user;
    }

    /**
     * @param User $user
     * @return User
     * @depends testLastName
     */
    public function testEmail(User $user): User
    {
        $user->setEmail("User@Email.com");
        $this->assertSame("User@Email.com",$user->getEmail());
        return $user;
    }

    /**
     * @param User $user
     * @return User
     * @depends testEmail
     */
    public function testPhoneNumber(User $user): User
    {
        $user->setPhoneNumber("+989124525612");
        $this->assertSame("+989124525612",$user->getPhoneNumber);
        return $user;
    }

    /**
     * @param User $user
     * @return User
     * @depends testPhoneNumber
     */
    public function testPassword(User $user): User
    {
        $pass = "password";
        $hash = md5($pass);
        $user->setPassword($hash);
        $this->assertSame(md5($pass),$user->getPassword());
        return $user;
    }



}