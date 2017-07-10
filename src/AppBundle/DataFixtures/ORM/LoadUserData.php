<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Faker\Factory;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userRoles = [User::ROLE_ADMIN, User::ROLE_MANAGER, User::ROLE_USER];

        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setPassword($faker->password());
            $user->setActive($faker->boolean());
            $user->setCreatedAt(
                $faker->dateTimeBetween('-3 years', 'now')
            );
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->addRole($faker->randomElement($userRoles));

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
