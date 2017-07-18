<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\EditQuizType;
use AppBundle\Entity\Quiz;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends Controller
{
    /**
     * @param Quiz $quiz
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/quiz/{quiz_id}/edit", name="admin.quiz.edit")
     *
     * @ParamConverter("quiz", options={"id" = "quiz_id"})
     */
    public function editAction(Quiz $quiz, Request $request)
    {
        $form = $this->createForm(EditQuizType::class, $quiz);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($quiz);
            $em->flush();

            $this->addFlash(
                'notice',
                'Quiz has been successfully modified!'
            );

            return $this->redirectToRoute('admin.quiz.edit', [
                'quiz_id' => $quiz->getId(),
            ]);
        }
        return $this->render('admin/quiz/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
