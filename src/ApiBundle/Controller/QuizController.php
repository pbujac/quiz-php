<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

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
     */
    public function quizSearch(Request $request)
    {
        $filter = $request->get('filter');


    }
}
