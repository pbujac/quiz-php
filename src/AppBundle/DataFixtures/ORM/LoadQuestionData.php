<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadQuestionData implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $quizzes = $manager->getRepository(Quiz::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $question = new Question();
            $question->setText($faker->text);
            $question->setQuiz($faker->randomElement($quizzes));

            $manager->persist($question);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }

}
