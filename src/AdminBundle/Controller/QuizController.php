<?php

namespace AdminBundle\Controller;

use AdminBundle\Manager\PaginatorManager;
use AppBundle\Entity\Quiz;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class QuizController extends Controller
{
    /**
     * @param int $page = 1
     *
     * @return RedirectResponse|Response
     *
     * @Route("/quiz/list/{page}",name="admin.quiz.list")
     */
    public function listAction(Request $request, int $page = 1)
    {
        $filter = $request->get('filter');

        $quizzes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->getByFilter($filter ,$page);

        $maxPages = ceil($quizzes->count() / PaginatorManager::PAGE_LIMIT);

        return $this->render('admin/quiz/list.html.twig', [
            'quizzes' => $quizzes->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'currentPage' => $page,
        ]);
    }

    /**
     * @param Quiz $quiz
     *
     * @return RedirectResponse|Response
     *
     * @Route("/quiz/{quiz_id}/delete", name="admin.quiz.delete")
     *
     * @ParamConverter("quiz", options={"id" = "quiz_id"})
     */
    public function deleteAction(Quiz $quiz)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($quiz);
        $em->flush();

        $this->addFlash(
            'notice',
            'Quiz has been successfully removed!'
        );

        return $this->redirectToRoute('admin.quiz.list');
    }
}
