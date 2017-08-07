<?php

namespace ApiBundle\Controller;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\Handler\QuizHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Quiz;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/quizzes")
 */
class QuizController extends FOSRestController
{
    /**
     * @Rest\Post("", name="quizzes.create")
     *
     * @param QuizDTO $quizDTO
     *
     * @return View
     */
    public function postAction(QuizDTO $quizDTO): View
    {
        $this->get(QuizHandler::class)->handleCreate($quizDTO);

        return View::create($quizDTO, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/{id}",name="quiz.delete")
     *
     * @param Quiz $quiz
     * @ParamConverter("quiz")
     *
     * @return View
     */
    public function deleteAction(Quiz $quiz): View
    {
        $this->get(QuizHandler::class)->handleDelete($quiz);

        return View::create(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Rest\Get("/{quizId}", name="quizzes.quiz.get")
     *
     * @param int $quizId
     *
     * @return View
     */
    public function getByIdAction(int $quizId): View
    {
        $quizDTO = $this->get(QuizHandler::class)->handleGetQuiz($quizId);

        return View::create($quizDTO, Response::HTTP_OK);
    }

    /**
     * @Rest\Patch("/{id}", name="quizzes.quiz.patch")
     *
     * @param Quiz $quiz
     * @param QuizDTO $quizDTO
     *
     * @return View
     */
    public function patchAction(QuizDTO $quizDTO, Quiz $quiz): View
    {
        $quizDTO = $this->get(QuizHandler::class)->handlePatch($quizDTO, $quiz);

        return View::create($quizDTO, Response::HTTP_OK);
    }

}
