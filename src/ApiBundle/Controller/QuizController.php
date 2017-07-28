<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\BrowserKit\Response;

/**
 * @Rest\Route("/quizzes/{id}")
 */
class QuizController extends FOSRestController
{
    /**
     * @Rest\Delete()
     *
     * @param int $id
     *
     * @return Response
     *
     * @Rest\Route("/quizzes/{id}", name="admin.quiz.delete")
     *
     * @ParamConverter("quiz", options={"id" = "quiz_id"})
     */
    public function deleteQuizById($id)
    {
        $quiz = $this->getDoctrine()
            ->getRepository('AppBundle:Quiz')
            ->findOneBy(array('id'=>$id));

        if (!$quiz) {
            throw $this->createNotFoundException(sprintf(
                'No quiz found with id "%i"',
                $id
            ));
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
