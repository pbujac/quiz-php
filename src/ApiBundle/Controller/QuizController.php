<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Quiz;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/quizzes")
 */
class QuizController extends FOSRestController
{
    /**
     * @Rest\Delete("/{quiz_id}")
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

        return new Response(null ,204);
    }
}
