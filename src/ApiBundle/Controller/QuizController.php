<?php

namespace ApiBundle\Controller;

use ApiBundle\Handler\QuizHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
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
     * @Rest\QueryParam(name="")
     *
     * @Rest\Route(name="api.quiz.search")
     *
     * @Rest\QueryParam(
     *   name="title"
     * )
     *
     * @Rest\QueryParam(
     *   name="description"
     * )
     *
     * @Rest\QueryParam(
     *   name="category"
     * )
     *
     * @Rest\QueryParam(
     *   name="author"
     * )
     *
     * @param ParamFetcher $paramFetcher
     * @param int $page
     *
     * @return View
     */
    public function search(ParamFetcher $paramFetcher, int $page = 1)
    {
        $quizzes = $this->get(QuizHandler::class)->searchByFilter(
            $page,
            $paramFetcher
        );

        return View::create($quizzes, Response::HTTP_OK);
    }
}
