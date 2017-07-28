<?php

namespace ApiBundle\Controller;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\Handler\QuizHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends FOSRestController
{
    /**
     * @Rest\Post("/quizzes", name="quizzes")
     *
     * @param QuizDTO $quizDTO
     *
     * @return View
     */
    public function createAction(QuizDTO $quizDTO)
    {
        $this->get(QuizHandler::class)->postAction($quizDTO);

        return View::create($quizDTO, Response::HTTP_CREATED);
    }
}
