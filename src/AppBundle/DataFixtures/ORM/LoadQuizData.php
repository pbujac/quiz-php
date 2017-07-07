<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Category;
use AppBundle\Entity\Quiz;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;


class LoadQuizData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        $categories = $manager->getRepository(Category::class)->findAll();


        for ($i = 0; $i < 10; $i++) {
            $quiz = new Quiz();
            $quiz->setTitle($faker->title);
            $quiz->setAuthor($faker->randomElement($users));
            $quiz->setCreatedAt($faker->dateTime);
            $quiz->setCategory($faker->randomElement($categories));
            $quiz->setDescription($faker->text);

            $manager->persist($quiz);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
