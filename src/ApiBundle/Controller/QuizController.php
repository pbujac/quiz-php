<?php

namespace ApiBundle\Controller;

use ApiBundle\Handler\QuizSearchHandler;
use AppBundle\Entity\Quiz;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;

//use AdminBundle\Manager\PaginatorManager;

/**
 * @Rest\Route("/quizzes")
 */
class QuizController extends QuizSearchHandler
{
    /**
     * @Rest\Get()
     *
     * @Rest\Route("/{filter}", name="api.search.quiz")
     *
     * @param Request $request
     * @param int $page
     * @param Quiz $quiz
     *
     * @return View
     */
    public function quizSearch(Request $request, int $page = 1, Quiz $quiz)
    {
        $filter = $request->get('filter');

        $quizzes[]=$this->handleQuizByFilter($filter);


        foreach ($quizzes as $quiz) {
            $quizzes[] = array(
                $quiz->getTitle(),
                $quiz->getDescription(),
                $quiz->getCreatedAt(),
                $quiz->getCategody(),
                $quiz->getAuthor()
            );
        }


//        $maxPages = ceil(count($quizzes) / PaginatorManager::PAGE_LIMIT);

        return View::create($quizzes[] = $this->handleQuizSearch($quiz), http_response_code(200));

    }
}
