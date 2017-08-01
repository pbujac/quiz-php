<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\LoginDTO;
use Firebase\JWT\JWT;

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
    public function handleLogin(LoginDTO $loginDTO): array
    {
        return $this->generateToken($loginDTO);
    }

    /**
     * @param LoginDTO $loginDTO
     *
     * @return array
     */
    private function generateToken(LoginDTO $loginDTO): array
    {
        $expirationDate = new \DateTime();
        $token = [
            "username" => $loginDTO->username,
            "nbf" => $expirationDate->getTimestamp()
        ];

        $jwt = JWT::encode($token, $this->secretKey);

        return $tokenResponse = [
            'token' => $jwt,
            'token_exp' => $expirationDate->getTimestamp(),
        ];
    }
}
