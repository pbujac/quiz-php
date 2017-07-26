<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\LoginDTO;
use AppBundle\Entity\AccessToken;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;

class LoginHandler
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var string $secretKey */
    private $secretKey;

    /**
     * @param EntityManagerInterface $em
     * @param string $secretKey
     */
    public function __construct(
        EntityManagerInterface $em,
        string $secretKey
    ) {
        $this->em = $em;
        $this->secretKey = $secretKey;
    }

    /**
     * @param LoginDTO $loginDTO
     *
     * @return AccessToken
     */
    public function login(LoginDTO $loginDTO)
    {
        $user = $this->em->getRepository(User::class)->findOneBy([
            'username' => $loginDTO->username
        ]);
        $token = $this->generateToken($loginDTO, $user);

        $this->em->persist($token);
        $this->em->flush();

        return $token;
    }

    /**
     * @param LoginDTO $loginDTO
     * @param User $user
     *
     * @return AccessToken
     */
    public function generateToken(LoginDTO $loginDTO, User $user): AccessToken
    {
        $expireTokenDate = new \DateTime();
        $expireTokenDate->modify('+1 month');
        $newToken = JWT::encode(
            [random_int(1, 10) . $loginDTO->username],
            $this->secretKey
        );

        $token = new AccessToken();
        $token->setUser($user);
        $token->setExpireAt($expireTokenDate);
        $token->setAccessToken($newToken);

        return $token;
    }
}
