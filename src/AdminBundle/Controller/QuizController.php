<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\QuizType;
use AppBundle\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends Controller
{
    /**
     * @Route("/quiz", name="quiz")
     */
    public function quizAction(Request $request)
    {
        $quiz = new Quiz();
        $quiz->setTitle('');
        $quiz->setDescription('');
        $quiz->setCategory('');
        $form = $this->createForm(QuizType::class, $quiz);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($quiz);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('quiz');
        }

        return $this->render(
            '@Admin/admin/quiz/quiz.html.twig',
            array('form' => $form->createView())
        );
    }
}
