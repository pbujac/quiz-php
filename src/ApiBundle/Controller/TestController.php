<?php

namespace ApiBundle\Controller;

use ApiBundle\DTO\LoginDTO;
use ApiBundle\Handler\LoginHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/test")
 */
class TestController extends FOSRestController
{
    /**
     * @Rest\Get()

     *
     * @return View
     */
    public function postAction()
    {

        return View::create(['test'], Response::HTTP_OK);
    }

}
