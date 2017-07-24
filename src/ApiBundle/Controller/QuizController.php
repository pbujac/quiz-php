<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/quiz")
 */
class QuizController extends FOSRestController
{
    /**
     * @Rest\Get()
     *
     * @return View
     */
    public function getAction()
    {
        return View::create("test", Response::HTTP_OK);
    }

}
