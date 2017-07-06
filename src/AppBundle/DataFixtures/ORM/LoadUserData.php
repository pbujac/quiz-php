<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Faker\Factory;

class LoadUserData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userRoles = array("ADMIN", "ROLE1", "ROLE2");

        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setPassword($faker->password());
            $user->setActive(1);
            $user->setCreatedAt(
                $faker->dateTimeBetween(
                    $startDate = '-3 years',
                    $endDate = 'now',
                    $timezone = date_default_timezone_get())
            );
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setRole($userRoles[array_rand($userRoles, 1)]);

            $manager->persist($user);
            $manager->flush();
        }
    }
}