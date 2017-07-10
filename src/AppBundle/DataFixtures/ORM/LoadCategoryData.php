<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;


class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {

            $category = new Category();
            $category->setTitle($faker->title);

            $manager->persist($category);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }

}
