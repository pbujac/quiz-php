<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\LoginDTO;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class LoginHandler
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param LoginDTO $loginDTO
     */
    public function postLoginHandler(LoginDTO $loginDTO)
    {
//        $this->validator->validate(LoginDTO::class);

//        $this->encoder->encodePassword($loginDTO->getUser(), $loginDTO->getPassword());
//
        $user = $this->em->getRepository(User::class)->findOneBy([
            'username' => $loginDTO->getUsername(),
            'password' => $loginDTO->getUser()->getPassword(),
        ]);
//
//        if (!$user) {
//            // generate token
//            // AUTHENTIFICATION
//        }

    }
}
