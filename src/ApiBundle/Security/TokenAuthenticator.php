<?php

namespace ApiBundle\Security;

use ApiBundle\DTO\LoginDTO;
use AppBundle\Entity\AccessToken;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    /**@var EntityManager */
    private $em;

    /** @var UserPasswordEncoderInterface $encoder */
    private $encoder;

    /** @var ValidatorInterface $validator */
    private $validator;

    /**
     * @param EntityManager $em
     * @param UserPasswordEncoderInterface $encoder
     * @param ValidatorInterface $validator
     */
    public function __construct(
        EntityManager $em,
        UserPasswordEncoderInterface $encoder,
        ValidatorInterface $validator
    ) {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->validator = $validator;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $authException
     *
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new BadRequestHttpException("Credentials are invalid");
    }

    /**
     * @param Request $request
     *
     * @return mixed|null
     */
    public function getCredentials(Request $request)
    {
        return [
            'token' => $request->headers->get('authentication'),
            'username' => $request->get('username'),
            'password' => $request->get('password')
        ];
    }

    /**
     * @param array $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if ($credentials['token']) {
            $this->validateToken($credentials);

            return $this->getUserByToken($credentials, $userProvider);
        }
        $this->validateUser($credentials);

        return $this->getUserByUsername($credentials, $userProvider);
    }

    /**
     * @param array $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if (
            !$user ||
            !$this->encoder->isPasswordValid($user, $credentials['password'])
        ) {
            throw new BadRequestHttpException("Credentials are invalid");
        }

        return true;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        throw new BadRequestHttpException("Credentials are invalid");
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * @param $credentials
     * @param UserProviderInterface $userProvider
     * @return UserInterface
     */
    public function getUserByUsername($credentials, UserProviderInterface $userProvider): UserInterface
    {
        $user = $this->em->getRepository(User::class)->findOneBy([
            'username' => $credentials['username']
        ]);

        if (!$user) {
            throw new BadRequestHttpException("Credentials are invalid");
        }
        $username = $user->getUsername();

        return $userProvider->loadUserByUsername($username);
    }

    /**
     * @param $credentials
     * @param UserProviderInterface $userProvider
     * @return UserInterface
     */
    public function getUserByToken($credentials, UserProviderInterface $userProvider): UserInterface
    {
        $accessToken = $this->em->getRepository(AccessToken::class)
            ->findOneBy([
                'accessToken' => $credentials['token']
            ]);

        if (!$accessToken) {
            throw new BadRequestHttpException("Credentials are invalid");
        }
        $username = $accessToken->getUser()->getUsername();

        return $userProvider->loadUserByUsername($username);
    }

    /**
     * @param array $credentials
     */
    private function validateToken($credentials)
    {
        $loginDTO = new LoginDTO();
        $loginDTO->token = $credentials['token'];

        $errors = $this->validator->validate($loginDTO, null, [
            'token'
        ]);
        if (count($errors) > 0) {
            throw new BadCredentialsException("Credentials are invalid");
        }
    }

    /**
     * @param array $credentials
     */
    private function validateUser($credentials)
    {
        $loginDTO = new LoginDTO();
        $loginDTO->username = $credentials['username'];
        $loginDTO->password = $credentials['password'];

        $errors = $this->validator->validate($loginDTO, null, [
            'login'
        ]);
        if (count($errors) > 0) {
            throw new BadCredentialsException("Credentials are invalid");
        }
    }
}
