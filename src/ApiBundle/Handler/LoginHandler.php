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
    /** @var string $secretKey */
    private $secretKey;

    /**
     * @param string $secretKey
     */
    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @param LoginDTO $loginDTO
     *
     * @return array
     */
    public function generateToken(LoginDTO $loginDTO): array
    {
        $token = [
            "username" => $loginDTO->username,
            "nbf" => (new \DateTime())->getTimestamp()
        ];

        $jwt = JWT::encode($token, $this->secretKey);

        return $tokenResponse = [
            'token' => $jwt,
            'token_exp' => (new \Datetime())->getTimestamp(),
        ];
    }
}
