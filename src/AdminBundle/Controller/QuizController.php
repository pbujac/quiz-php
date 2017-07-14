<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\AnswerType;
use AdminBundle\Form\QuizType;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;
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
        $quiz = new Quiz();
        $question = new Question();
        $question->addAnswer(new Answer());
        $quiz->addQuestion($question);

        $form = $this->createForm(QuizType::class,$quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quiz = $form->getData();

            $quiz->setCreatedAt(new \DateTime());
            $quiz->setAuthor($this->get('security.token_storage')->getToken()->getUser());
            $question->setQuiz($quiz);

            $em = $this->getDoctrine()->getManager();
            $em->persist($quiz);
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('admin.dashboard');
        }

        return $this->render(
            "admin/quiz/quiz.html.twig",
            array('form' => $form->createView())
        );
    }
}
