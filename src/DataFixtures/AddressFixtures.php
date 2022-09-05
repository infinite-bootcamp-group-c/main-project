<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AddressFixtures extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        $configs = include('src/DataFixtures/FixtureConfig.php');
        $address_cnt = $configs['address_cnt'];
        for ($i = 1; $i <= $address_cnt; $i++) {
            $address = new Address();
            $address->setTitle('address'.$i);
            $address->setAddressDetails('address detail'.$i);
            $address->setCity('City'.$i);
            $address->setCountry('Country'.$i);
            $address->setLatitude($i*10);
            $address->setLongitude($i*15);
            $address->setPostalCode('0912345678'.$i);
            $address->setProvince(''.$i);

            $manager->persist($address);
        }

        $manager->flush();
    }


    public static function getGroups(): array
    {
        return ['address'];
    }
}