<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

/*
 * Running with php bin/console doctrine:fixtures:load
 *
 * By default the load command purges the database, removing all data from every table.
 * To append your fixtures' data add the --append option.
 *
 * This command looks for all services tagged with doctrine.fixture.orm.
 *
 * To see other options for the command, run:
 *
 * php bin/console doctrine:fixtures:load --help
 *
 * if want to always start with index 1 add --purge-with-truncate or use this:
 *
 * To Erase tables from the database run:
 * php bin/console doctrine:schema:drop --force && php bin/console doctrine:schema:update --force
 *
 * To exclude a table use --purge-exclusions=TableName
 *
 * Run the command to add by order:
 * php bin/console doctrine:fixtures:load --group=user --append && php bin/console doctrine:fixtures:load --group=shop --append && php bin/console doctrine:fixtures:load --group=category --append && php bin/console doctrine:fixtures:load --group=product --append && php bin/console doctrine:fixtures:load --group=address --append && php bin/console doctrine:fixtures:load --group=order --append  && php bin/console doctrine:fixtures:load --group=order_transaction --append
 * php bin/console --env=test doctrine:fixtures:load --group=user --append && php bin/console --env=test doctrine:fixtures:load --group=shop --append && php bin/console --env=test doctrine:fixtures:load --group=category --append && php bin/console --env=test doctrine:fixtures:load --group=product --append && php bin/console --env=test doctrine:fixtures:load --group=address --append && php bin/console --env=test doctrine:fixtures:load --group=order --append  && php bin/console --env=test doctrine:fixtures:load --group=order_transaction --append
 *
*/

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager):void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public static function getGroups():array
    {
        return ['app'];
    }
}