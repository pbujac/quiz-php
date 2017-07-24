<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\LoginDTO;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class LoginHandler
{
    /** @var EntityManager $em */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param LoginDTO $loginDTO
     */
    public function postLoginHandler(LoginDTO $loginDTO)
    {
//        $this->validator->validate($loginDTO);

//        $this->encoder->encodePassword($loginDTO->getUser(), $loginDTO->getPassword());
//
//        $this->em->getRepository(User::class);
//
//        if (!$user) {
//            // generate token
//            // AUTHENTIFICATION
//        }

    }
}
