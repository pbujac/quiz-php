<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Quiz;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;


class LoadQuizData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $faker = Factory::create();

            $quiz = new Quiz();
            $quiz->setTitle($faker->title);
            $quiz->setCreatedAt($faker->dateTime);
            $quiz->setDescription($faker->text);
            $manager->persist($quiz);
        }

        $manager->flush();
    }
    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 3;
    }

}
