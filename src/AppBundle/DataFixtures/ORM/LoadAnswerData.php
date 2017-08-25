<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadAnswerData implements FixtureInterface,OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $questions = $manager->getRepository(Question::class)->findAll();

//        for ($i = 0; $i < 10; $i++) {
//            $answer = new Answer();
//            $answer->setText($faker->text);
//            $answer->setCorrect($faker->boolean());
//            $answer->setQuestion($faker->randomElement($questions));
//
//            $manager->persist($answer);
//        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }

}
