<?php

namespace ApiBundle\Controller;

use ApiBundle\DTO\LoginDTO;
use ApiBundle\Handler\LoginHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/login")
 */
class SecurityController extends FOSRestController
{
    /**
     * @Rest\Post()
     *
     * @param LoginDTO $loginDTO
     *
     * @return View
     */
    public function postAction(LoginDTO $loginDTO)
    {
        $token = $this->get(LoginHandler::class)->login($loginDTO);

        $tokenResponse = [
            'token' => $token->getAccessToken(),
            'token_exp' => $token->getExpireAt()->getTimestamp(),
        ];
        return View::create($tokenResponse, Response::HTTP_OK);
    }

}
