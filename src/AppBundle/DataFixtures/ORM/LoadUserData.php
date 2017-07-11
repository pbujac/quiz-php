<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $encoder = $this->container->get('security.password_encoder');

        for ($i = 0; $i < 40; $i++) {
            $user = new User();
            $user->setUsername($faker->userName);
            $user->setPassword($encoder->encodePassword($user, 'test'));
            $user->setActive($faker->boolean());
            $user->setCreatedAt(
                $faker->dateTimeBetween('-3 years', 'now')
            );
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->addRole($faker->randomElement(User::ROLES));

            $manager->persist($user);
        }

        $this->createAdminUser($faker, $manager, $encoder);

        $manager->flush();
    }

    /**
     * @param Generator $faker
     * @param ObjectManager $manager
     * @param UserPasswordEncoder $encoder
     */
    private function createAdminUser(Generator $faker, ObjectManager $manager, UserPasswordEncoder $encoder)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($encoder->encodePassword($user, 'admin'));
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
