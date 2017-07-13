<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\Quiz;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuizControler extends Controller
{
    /**
     * @Route("/quiz",name="admin.quiz.list")
     *
     */
    public function quizListAction(Request $request)
    {
        $page = $request->get('page', 1);

        $quizzes = $this->getDoctrine()->getRepository(Quiz::class)->getAllQuizzes($page);

        $limit = 19;
        $maxPages = ceil($quizzes->count() / $limit);

        return $this->render('quizList/list.html.twig', [
            'quizes' => $quizzes->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'thisPage' => $page,
        ]);
    }



}
