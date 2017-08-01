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
    public function postAction(QuizDTO $quizDTO)
    {
        $this->get(QuizHandler::class)->handleCreate($quizDTO);

        return View::create($quizDTO, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/{quiz_id}",name="quiz.delete")
     *
     * @param Quiz $quiz
     * @ParamConverter("quiz", options={"id" = "quiz_id"})
     *
     * @return Response
     */
    public function deleteQuizById(Quiz $quiz)
    {
        if (!$quiz) {
            throw $this->createNotFoundException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($quiz);
        $em->flush();

        $this->addFlash(
            'notice',
            'Quiz has been successfully removed!'
        );

        return new Response(null,Response::HTTP_NO_CONTENT);
    }
}
