<?php

namespace ApiBundle\Controller;

use AdminBundle\Manager\PaginatorManager;
use ApiBundle\DTO\QuizDTO;
use ApiBundle\Handler\QuizHandler;
use AppBundle\Entity\Category;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends FOSRestController
{
    /**
     * @Rest\Post(
     *     "/quizzes",
     *     name="quizzes"
     * )
     * @param QuizDTO $quizDTO
     *
     * @return View
     */
    public function createAction(QuizDTO $quizDTO)
    {
        $this->get(QuizHandler::class)->postAction(
            $quizDTO,
            $this->getUser()
        );

        return View::create($quizDTO, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get(
     *     "/user/quizzes" ,
     *     name="api.user.quizzes"
     * )
     * @param Request $request
     *
     * @return View
     */
    public function getQuizzesByUserAction(Request $request)
    {
        $user = $this->getUser();
        $page = $request->get('page') ?: 1;
        $count = $request->get('count') ?: PaginatorManager::PAGE_LIMIT;

        $quizzes = $this->get(QuizHandler::class)
            ->getQuizzesByUser($user, $page, $count);

        return View::create($quizzes, Response::HTTP_OK);
    }

    /**
     * @Rest\Get(
     *     "/category/{category_id}/quizzes" ,
     *     name="api.category.quizzes"
     * )
     * @param Request $request
     * @param Category $category
     *
     * @ParamConverter(
     *     "category",
     *     options={"id" = "category_id"}
     * )
     * @return View
     */
    public function getQuizzesByCategoryAction(
        Request $request,
        Category $category
    ) {
        $page = $request->get('page') ?: 1;
        $count = $request->get('count') ?: PaginatorManager::PAGE_LIMIT;

        $quizzes = $this->get(QuizHandler::class)
            ->getQuizzesByCategory($category, $page, $count);

        return View::create($quizzes, Response::HTTP_OK);
    }

}
