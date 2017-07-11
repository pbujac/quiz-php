<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Faker\Factory;
use Faker\Generator;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setPassword(password_hash('test', PASSWORD_BCRYPT));
            $user->setActive($faker->boolean());
            $user->setCreatedAt(
                $faker->dateTimeBetween('-3 years', 'now')
            );
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->addRole($faker->randomElement(User::ROLES));

            $manager->persist($user);
        }

        $this->createAdminUser($faker, $manager);

        $manager->flush();
    }

    /**
     * @param Generator $faker
     * @param ObjectManager $manager
     */
    private function createAdminUser($faker, ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword(password_hash('admin', PASSWORD_BCRYPT));
        $user->setActive(1);
        $user->setCreatedAt(
            $faker->dateTimeBetween('-3 years', 'now')
        );
        $user->setFirstName($faker->firstName);
        $user->setLastName($faker->lastName);
        $user->addRole(User::ROLE_ADMIN);

        $manager->persist($user);
    }

    public function getOrder()
    {
        return 1;
    }
}
