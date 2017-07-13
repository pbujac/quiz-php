<?php

namespace AdminBundle\Controller;

use AdminBundle\Manager\PaginatorManager;
use AppBundle\Entity\Quiz;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizControler extends Controller
{
    /**
     * @param int $page = 1
     *
     * @return RedirectResponse|Response
     *
     * @Route("/quiz/list/{page}",name="admin.quiz.list")
     */
    public function userListAction(Request $request, int $page = 1)
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


}
