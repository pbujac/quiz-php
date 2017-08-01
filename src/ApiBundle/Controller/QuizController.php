<?php

namespace ApiBundle\Controller;

use ApiBundle\Handler\QuizHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/quizzes")
 */
class QuizController extends FOSRestController
{
    /**
     * @Rest\Get()
     *
     * @Rest\Route(name="api.quiz.search")
     *
     * @param Request $request
     * @param int $page
     *
     * @return View
     */
    public function search(Request $request, int $page = 1)
    {
        $filter = $request->get('filter');

        $quizzes = $this->get(QuizHandler::class)->searchByFilter($page, $filter);

        return View::create($quizzes, Response::HTTP_OK);
    }
}
