<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Result;
use AppBundle\Entity\User;
use AppBundle\Entity\Quiz;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadResultData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        $quizzes = $manager->getRepository(Quiz::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $result = new Result();
            $result->setUser($faker->randomElement($users));
            $result->setQuiz($faker->randomElement($quizzes));
            $result->setCreatedAt($faker->dateTime);
            $result->setScore($faker->numberBetween(0, 100));
            $result->setFinished($faker->boolean());

            $manager->persist($result);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
