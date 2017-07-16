<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\QuizType;
use AdminBundle\Manager\PaginatorManager;
use AppBundle\Entity\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends Controller
{
    /**
     * @param int $page = 1
     *
     * @return RedirectResponse|Response
     *
     * @Route("/quiz/list/{page}",name="admin.quiz.list")
     */
    public function userListAction(int $page = 1)
    {
        $quizzes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->getAllQuizzesByPage($page);

        $maxPages = ceil($quizzes->count() / PaginatorManager::PAGE_LIMIT);

        return $this->render('admin/quiz/list.html.twig', [
            'quizzes' => $quizzes->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'currentPage' => $page,
        ]);
    }

    /**
     * @param Quiz $quiz
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/quiz/{quiz}/edit", name="admin.quiz.edit")
     */
    public function editAction(Quiz $quiz, Request $request)
    {
        $form = $this->createForm(QuizType::class, $quiz);

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
                'quiz' => $quiz->getId()
            ]);
        }

        return $this->render('admin/quiz/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
