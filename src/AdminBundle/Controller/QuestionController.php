<?php

namespace AdminBundle\Controller;


use AdminBundle\Form\QuestionType;
use AppBundle\Entity\Question;
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
     *
     * @return RedirectResponse|Response
     *
     * @Route("/question/create", name="admin.question.create")
     */
    public function createAction(Request $request)
    {
        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            return $this->redirectToRoute('admin.category.list');
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

        $form = $this->createForm(QuestionType::class, $question, [
            'label' => false
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            foreach ($question->getAnswers() as $answer) {

                if (!$originalAnswers->contains($answer)) {
                    $answer->setQuestion($question);
                    $em->persist($answer);
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
     * @param Request $request
     * @param Question $question
     *
     * @return RedirectResponse|Response
     *
     * @Route("/question/{question}/delete", name="admin.question.delete")
     */
    public function deleteAction(Question $question, Request $request)
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
}
