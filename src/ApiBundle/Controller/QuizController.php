<?php

namespace ApiBundle\Controller;

use ApiBundle\Handler\QuizHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/quizzes")
 */
class QuizController extends FOSRestController
{
    /**
     * @Rest\Get()
     *
     * @Rest\QueryParam(name="filter")
     *
     * @Rest\Route(name="api.quiz.search")
     *
     * @param ParamFetcherInterface $paramFetcher
     * @param int $page
     *
     * @return View
     */
    public function search(ParamFetcherInterface $paramFetcher, int $page = 1)
    {
        $filter = $paramFetcher->get('filter');

        $quizzes = $this->get(QuizHandler::class)->searchByFilter($page, $filter);

        return View::create($quizzes, Response::HTTP_OK);
    }
}
