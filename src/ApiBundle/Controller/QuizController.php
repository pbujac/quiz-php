<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Quiz;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class QuizController extends Controller
{
    /**
     * @Rest\Get("/quiz", name="quizById")
     */
    public function getQuizAction()
    {
        $quizzes[] = $this->getDoctrine()->getRepository(Quiz::class)->findAll();
        if(is_null($quizzes)){
            throw $this->createNotFoundException();
        }

        $this->render(':api:file.html.twig');
//        return $quizzes;
    }
}
