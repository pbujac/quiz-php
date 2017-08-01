<?php

namespace ApiBundle\Controller;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\Handler\QuizHandler;
use AppBundle\Entity\Quiz;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
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
    public function postAction(QuizDTO $quizDTO)
    {
        $this->get(QuizHandler::class)->handleCreate($quizDTO);

        return View::create($quizDTO, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/{quizId}", name="quiz.id")
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
     * @Rest\Patch("/{quizId}", name="quizzes.id")
     *
     * @param QuizDTO $quizDTO
     * @param Quiz $quiz
     *
     * @ParamConverter(
     * "quiz",
     * options={"id" = "userId"}
     * )
     *
     * @return View
     */
    public function patchAction(QuizDTO $quizDTO, Quiz $quiz)
    {
        $quizDTO = $this->get(QuizHandler::class)->handlePatch($quizDTO, $quiz);

        return View::create($quizDTO, Response::HTTP_OK);
    }
}
