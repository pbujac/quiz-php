<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ResultAnswer;
use AppBundle\Entity\Result;
use AppBundle\Entity\Question;
use AppBundle\Entity\Answer;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class LoadResultAnswerData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $results = $manager->getRepository(Result::class)->findAll();
        $questions = $manager->getRepository(Question::class)->findAll();
        $answers = $manager->getRepository(Answer::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $resultAnswer = new ResultAnswer();
            $resultAnswer->setResult($faker->randomElement($results));
            $resultAnswer->setQuestion($faker->randomElement($questions));
            $resultAnswer->setAnswer($faker->randomElement($answers));

            $manager->persist($resultAnswer);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
