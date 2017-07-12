<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Quiz;
use Doctrine\DBAL\Types\StringType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class QuizType extends Controller
{
    public function createQuiz(Request $request)
    {
        $quiz = new Quiz();
//        $quiz->setTitle()
        $form = $this->createFormBuilder($quiz)
            ->add('Title', StringType::class)
            ->add('save', SubmitType::class, array('label' => 'Save Quiz'))
            ->getForm();
        return $this->render('@Admin/admin/quiz/quiz.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
