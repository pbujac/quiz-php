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
        $token = $this->get(LoginHandler::class)->handleLogin($loginDTO);

        return View::create($token, Response::HTTP_OK);
    }

}
