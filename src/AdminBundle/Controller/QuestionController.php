<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\QuestionType;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @Route("/question/{quiz_id}/create", name="admin.question.create")
     *
     * @ParamConverter("quiz", options={"id" = "quiz_id"})
     */
    public function createAction(Quiz $quiz, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $question = new Question();
        $question->addAnswer(new Answer());
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

            $this->addFlash(
                'notice',
                'Question has been successfully added!'
            );

            return $this->redirectToRoute('admin.quiz.edit', [
                "quiz_id" => $quiz->getId(),
            ]);
        }
        return $this->render('admin/question/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Question $question
     *
     * @return RedirectResponse|Response
     *
     * @Route("/question/{question_id}/edit", name="admin.question.edit")
     *
     * @ParamConverter("question", options={"id" = "question_id"})
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

            $this->addFlash(
                'notice',
                'Question has been successfully modified!'
            );

            return $this->redirectToRoute('admin.quiz.edit', [
                "quiz_id" => $question->getQuiz()->getId(),
            ]);
        }
        return $this->render('admin/question/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Question $question
     *
     * @return RedirectResponse|Response
     *
     * @Route("/question/{question_id}/delete", name="admin.question.delete")
     *
     * @ParamConverter("question", options={"id" = "question_id"})
     */
    public function deleteAction(Question $question)
    {
        $em = $this->getDoctrine()->getManager();

        $count = $em->getRepository(Question::class)->countQuestionsByQuizId($question->getQuiz()->getId());
        if ($count == 0) {

        }
        $em->remove($question);
        $em->flush();

        $this->addFlash(
            'notice',
            'Question has been successfully removed!'
        );

        return $this->redirectToRoute('admin.quiz.edit', [
            "quiz_id" => $question->getQuiz()->getId(),
        ]);
    }
}

