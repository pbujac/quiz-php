<?php

namespace ApiBundle\Controller;

use AdminBundle\Manager\PaginatorManager;
use ApiBundle\DTO\QuizDTO;
use ApiBundle\DTO\ResultDTO;
use ApiBundle\Handler\QuizHandler;
use ApiBundle\Handler\ResultHandler;
use AppBundle\Entity\Category;
use AppBundle\Entity\Quiz;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ResultController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     "/user/results" ,
     *     name="api.user.results"
     * )
     * @param Request $request
     *
     * @return View
     */
    public function getResultsByUserAction(Request $request)
    {
        $user = $this->getUser();
        $page = $request->get('page') ?: 1;
        $count = $request->get('count') ?: PaginatorManager::PAGE_LIMIT;

        $quizzes = $this->get(ResultHandler::class)
            ->handleGetResultsByUser($user, $page, $count);

        return View::create($quizzes, Response::HTTP_OK);
    }

}
