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
     * @Rest\Post("/quizzes", name="quizzes.create")
     *
     * @param QuizDTO $quizDTO
     *
     * @return View
     */
    public function postAction(QuizDTO $quizDTO)
    {
        $this->get(QuizHandler::class)->handleCreate($quizDTO);

        return View::create($quizDTO, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/quiz/{quizId}", name="quiz.id")
     *
     * @param int $quizId
     *
     * @return View
     */
    public function getByIdAction(int $quizId)
    {
        $quizDTO = $this->get(QuizHandler::class)->handleGetQuiz($quizId);

        return View::create($quizDTO, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/quizzes/{quizId}", name="quiz.id")
     *
     * @param int $quizId
     *
     * @return View
     */
    public function patchAction(int $quizId)
    {
        $quizDTO = $this->get(QuizHandler::class)->handleGetQuiz($quizId);

        return View::create($quizDTO, Response::HTTP_OK);
    }
}
