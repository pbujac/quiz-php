<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\QuizType;
use AppBundle\Entity\Quiz;
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
     * @Route("/quiz/edit/{quiz}", name="admin.quiz.edit")
     */
    public function editAction(Quiz $quiz, Request $request)
    {
        $form = $this->createForm(QuizType::class, $quiz);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            $em = $this->getDoctrine()->getManager();
//            $em->persist($quiz);
//            $em->flush();
//
//            $this->addFlash(
//                'notice',
//                'Quiz has been successfully modified!'
//            );
//
//            return $this->redirectToRoute('admin.quiz.edit');
        }

        return $this->render('admin/quiz/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
