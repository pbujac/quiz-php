<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;


class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $faker = Factory::create();
            $category = new Category();
            $category->setTitle($faker->title);
            $manager->persist($category);

        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }

}
