<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Route("/quizzes")
 */
class QuizController
{
    /**
     * @Rest\Get("/q:/{filter}")
     */
    public function quizSearch()
    {



    }
}
