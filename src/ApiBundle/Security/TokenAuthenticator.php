<?php

namespace ApiBundle\Security;

use AppBundle\Entity\AccessToken;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\HttpFoundation\Request;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    /**@var EntityManager */
    private $em;

    /** @var UserPasswordEncoderInterface $encoder */
    private $encoder;

    /**
     * @param EntityManager $em
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManager $em, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
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
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @throws AuthenticationException
     *
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (!$credentials['token']) {
            $user = $this->em->getRepository(User::class)->findOneBy([
                'username' => $credentials['username']
            ]);

            if (!$user) {
                throw new BadRequestHttpException("Credentials are invalid");
            }
            $username = $user->getUsername();
        } else {
            $accessToken = $this->em->getRepository(AccessToken::class)
                ->findOneBy([
                    'accessToken' => $credentials['token']
                ]);

            if (!$accessToken) {
                throw new BadRequestHttpException("Credentials are invalid");
            }
            $username = $accessToken->getUser()->getUsername();
        }
        return $userProvider->loadUserByUsername($username);
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        if (
            !$user &&
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
}
