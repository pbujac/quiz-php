<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Quiz;
use AdminBundle\Manager\PaginatorManager;

/**
 * @Rest\Route("/quizzes")
 */
class QuizController
{
    /**
     * @Rest\Get()
     *
     * @Rest\Route("/{filter}", name="api.search.quiz")
     *
     * @param Request $request
     * @param int $page
     */
    public function quizSearch(Request $request, int $page=1)
    {
        $filter = $request->get('filter');

        $quizzes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->getQuizByFilter($filter, $page);

        $maxPages = ceil($quizzes->count() / PaginatorManager::PAGE_LIMIT);

    }
}
