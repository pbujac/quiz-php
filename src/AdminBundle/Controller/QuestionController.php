<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\QuestionType;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends Controller
{
    /**
     * @param Request $request
     * @param Quiz $quiz
     *
     * @return RedirectResponse|Response
     *
     * @Route("/question/{quiz}/create", name="admin.question.create")
     */
    public function createAction(Quiz $quiz, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $question = new Question();
        $question->setQuiz($quiz);

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($question->getAnswers() as $answer) {
                $answer->setQuestion($question);
                $em->persist($answer);
            }

            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('admin.quiz.edit', [
                "quiz" => $quiz->getId(),
            ]);
        }
        return $this->render('admin/question/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Question $question
     *
     * @return RedirectResponse|Response
     *
     * @Route("/question/{question}/edit", name="admin.question.edit")
     */
    public function editAction(Question $question, Request $request)
    {
        $originalAnswers = new ArrayCollection($question->getAnswers()->toArray());

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            foreach ($question->getAnswers() as $answer) {

                if (!$originalAnswers->contains($answer)) {
                    $answer->setQuestion($question);
                    $em->persist($answer);
                }
            }

            foreach ($originalAnswers as $answer) {

                if (!$question->getAnswers()->contains($answer)) {
                    $em->remove($answer);
                }
            }
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('admin.quiz.edit', [
                "quiz" => $question->getQuiz()->getId(),
            ]);
        }
        return $this->render('admin/question/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Question $question
     *
     * @return RedirectResponse|Response
     *
     * @Route("/question/{question}/delete", name="admin.question.delete")
     */
    public function deleteAction(Question $question)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($question);
        $em->flush();

        return $this->redirectToRoute('admin.quiz.edit', [
            "quiz" => $question->getQuiz()->getId(),
        ]);
    }
}

