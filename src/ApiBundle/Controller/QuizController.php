<?php

namespace ApiBundle\Controller;

use ApiBundle\DTO\AnswerDTO;
use ApiBundle\DTO\QuestionDTO;
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
     * @param QuizHandler $quizHandler
     * @param QuizDTO $quizDTO
     *
     * @return View
     */
    public function createAction(QuizHandler $quizHandler, QuizDTO $quizDTO)
    {
//        die(dump($quizDTO));
        $quizHandler->insertQuiz($quizDTO);
        return View::create($quizDTO, Response::HTTP_CREATED);
    }
}
