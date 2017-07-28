<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\LoginDTO;
use AppBundle\Entity\AccessToken;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
        $user = $this->getUserByUsername($loginDTO);
        $token = $this->generateToken($loginDTO, $user);

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

        $token = [
            "username" => $loginDTO->username,
            "nbf" => (new \DateTime())->getTimestamp()
        ];

        $jwt = JWT::encode(
            $token,
            $this->secretKey
        );

        $token = new AccessToken();
        $token->setUser($user);
        $token->setExpireAt($expireTokenDate);
        $token->setAccessToken($jwt);

        return $token;
    }

    /**
     * @param LoginDTO $loginDTO
     * @return User|null|object
     */
    public function getUserByUsername(LoginDTO $loginDTO)
    {
        $user = $this->em->getRepository(User::class)->findOneBy([
            'username' => $loginDTO->username
        ]);

        if (!$user) {
            throw new BadRequestHttpException("Credentials are invalid");
        }

        return $user;
    }
}
