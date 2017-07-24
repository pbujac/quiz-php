<?php

namespace ApiBundle\Controller;

use ApiBundle\DTO\LoginDTO;
use ApiBundle\Handler\LoginHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SecurityController
 *
 * @Rest\Route("/login")
 */
class SecurityController extends FOSRestController
{
    /**
     * @Rest\Post()
     *
     * @param LoginDTO $loginDTO
     * @param LoginHandler $loginHandler
     *
     * @return View
     */
    public function postLoginAction(LoginDTO $loginDTO, LoginHandler $loginHandler)
    {
        $loginHandler->postLoginHandler($loginDTO);

        return View::create($loginDTO, Response::HTTP_OK);
    }

}
