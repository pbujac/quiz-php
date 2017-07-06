<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;


class LoadCategoryData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    { for ($i = 0; $i < 10; $i++){
            $faker = Factory::create();
            $category = new Category();
            $category->setTitle($faker->title);
            $manager->persist($category);

    }

    $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }

}
