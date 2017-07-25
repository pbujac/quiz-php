<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\LoginDTO;
use AppBundle\Entity\AccessToken;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoginHandler
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ValidatorInterface */
    private $validator;

    /** @var string $secretKey */
    private $encoder;

    /** @var string $secretKey */
    private $secretKey;

    /**
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param UserPasswordEncoderInterface $encoder
     * @param string $secretKey
     */
    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        UserPasswordEncoderInterface $encoder,
        string $secretKey
    )
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->encoder = $encoder;
        $this->secretKey = $secretKey;
    }

    /**
     * @param LoginDTO $loginDTO
     *
     * @return AccessToken
     */
    public function loginHandler(LoginDTO $loginDTO)
    {
        $errors = $this->validator->validate($loginDTO);

        if (count($errors) > 0) {
            throw new BadRequestHttpException();
        }
        $user = $this->em->getRepository(User::class)->findOneBy([
            'username' => $loginDTO->getUsername()
        ]);

        if (!$user || !$this->encoder->isPasswordValid($user, $loginDTO->getPassword())) {
            throw new BadRequestHttpException();
        }
        $token = new AccessToken();
        $token->setUser($user);
        $token->setExpireAt((new \DateTime())->modify('+1 month'));
        $token->setAccessToken(JWT::encode(
            [random_int(1, 10) . $loginDTO->getUsername()],
            $this->secretKey)
        );

        $this->em->persist($token);
        $this->em->flush();

        return $token;
    }
}
