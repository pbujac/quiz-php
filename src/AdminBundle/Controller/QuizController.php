<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\QuizType;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/quiz/create", name="quiz.create")
     */
    public function quizAction(Request $request)
    {
        $form = $this->createForm(QuizType::class, new Quiz());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quiz = $form->getData();
            $quiz->setAuthor($this->getUser());

            $em = $this->getDoctrine()->getManager();
            foreach ($quiz->getQuestions() as $question) {
                $question->setQuiz($quiz);
                $em->persist($question);
                foreach ($question->getAnswers() as $answer) {
                    $answer->setQuestion($question);
                    $em->persist($answer);
                }
            }
            $em->persist($quiz);
            $em->flush();

            return $this->redirectToRoute('admin.dashboard');
        }

        return $this->render(
            "admin/quiz/create.html.twig",
            array('form' => $form->createView())
        );
    }
}
