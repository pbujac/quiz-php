<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\LoginDTO;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoginHandler
{
    /** @var EntityManagerInterface */
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
    public function loginHandler(LoginDTO $loginDTO)
    {
//        $this->validator->validate(LoginDTO::class);
//
//        $this->encoder->encodePassword($loginDTO->getUser(), $loginDTO->getPassword());

        $user = $this->em->getRepository(User::class)->findOneBy([
            'username' => $loginDTO->getUsername(),
            'password' => $loginDTO->getUser()->getPassword(),
        ]);

        if (!$user) {

            foreach ($user->getAccessTokens() as $token) {
                $token->setExpireAt((new \DateTime())->modify('+1 month'));
                $token->setAccessToken(JWT::encode($user, $this->secret));
            }
            $this->em->persist($user);
            $this->em->flush();
        }
    }
}
