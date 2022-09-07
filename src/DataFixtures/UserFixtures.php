<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{

    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager)
    {
        $configs = include('src/DataFixtures/FixtureConfig.php');
        $user_cnt = $configs['user_cnt'];
        for ($i = 1; $i <= $user_cnt; $i++) {
            $user = new User($this->hasher);

            $user->setEmail('email'.$i.'@test.com');
            $user->setFirstName('firstName'.$i);
            $user->setLastName('lastName'.$i);
            $password = $this->hasher->hashPassword($user, '1234');
            $user->setPassword($password);
            $user->setPhoneNumber('+9891212345'.$i);
            $user->setRoles(['ROLE_USER']);

            $manager->persist($user);
        }

        $manager->flush();
    }


    public static function getGroups(): array
    {
        return ['user'];
    }
}