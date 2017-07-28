<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Quiz;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/quizzes")
 */

class QuizController
{
    /**
     * @Rest\Get("/{filter}")
     *
     * @param Request $request
     * @param int $page
     *
     * @return
     */
    public function quizSearch(Request $request, int $page = 1)
    {
//        $filter = $request->get('filter');
//
//        $quizzes = $this->getDoctrine()
//            ->getRepository(Quiz::class)
//            ->getQuizByFilter($filter, $page);
//
//        $maxPages = ceil($quizzes->count() / PaginatorManager::PAGE_LIMIT);
//
//        return $this->render('admin/quiz/list.html.twig', [
//            'quizzes' => $quizzes->getQuery()->getResult(),
//            'maxPages' => $maxPages,
//            'currentPage' => $page,
//        ]);
    }




}
