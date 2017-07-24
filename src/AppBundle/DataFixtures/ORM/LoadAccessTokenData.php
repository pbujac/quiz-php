<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\AccessToken;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Firebase\JWT\JWT;

class LoadAccessTokenData implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $users = $manager->getRepository(User::class)->findAll();
        $key = "token";
        $token = [
            "iat" => (new \DateTime())->getTimestamp(),
        ];

        for ($i = 0; $i < 10; $i++) {
            $accessToken = new AccessToken();
            $accessToken->setUser($faker->randomElement($users));
            $accessToken->setAccessToken(JWT::encode($token, $key));
            $accessToken->setExpireAt(new \DateTime());

            $manager->persist($accessToken);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
