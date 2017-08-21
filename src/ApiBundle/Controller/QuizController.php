<?php

namespace ApiBundle\Controller;

use AdminBundle\Manager\PaginatorManager;
use ApiBundle\DTO\QuizDTO;
use ApiBundle\DTO\ResultDTO;
use ApiBundle\Handler\QuizHandler;
use AppBundle\Entity\Category;
use AppBundle\Entity\Quiz;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends FOSRestController
{
    /**
     * @Rest\Get("/quizzes", name="api.quizzes.list")
     *
     * @Rest\QueryParam(
     *   name="title",
     *   default=null,
     *   nullable=true
     * )
     * @Rest\QueryParam(
     *   name="description",
     *   default=null,
     *   nullable=true
     * )
     * @Rest\QueryParam(
     *   name="category",
     *   default=null,
     *   nullable=true
     * )
     * @Rest\QueryParam(
     *   name="author",
     *   default=null,
     *   nullable=true
     * )
     *
     * @param Request $request
     * @param ParamFetcher $paramFetcher
     *
     * @return View
     */
    public function searchAction(Request $request, ParamFetcher $paramFetcher)
    {
        $filter = $paramFetcher->all();

        $page = $request->get('page') ?: 1;
        $count = $request->get('count') ?: PaginatorManager::PAGE_LIMIT;

        $quizzes = $this->get(QuizHandler::class)->searchByFilter(
            $page,
            $count,
            $filter
        );

        return View::create($quizzes, Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/quizzes", name="quizzes.create")
     *
     * @param QuizDTO $quizDTO
     *
     * @return View
     */
    public function postAction(QuizDTO $quizDTO): View
    {
        $this->get(QuizHandler::class)->handleCreate($quizDTO);

        return View::create($quizDTO, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/quizzes/{id}",name="api.quiz.delete")
     *
     * @param Quiz $quiz
     * @ParamConverter("quiz")
     *
     * @return View
     */
    public function deleteAction(Quiz $quiz): View
    {
        $this->get(QuizHandler::class)->handleDelete($quiz);

        return View::create(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @Rest\Get("/quizzes/{quiz_id}", name="quizzes.quiz.get")
     *
     * @param Quiz $quiz
     *
     * @ParamConverter(
     *     "quiz",
     *     options={"id" = "quiz_id"}
     * )
     * @return View
     */
    public function getByIdAction(Quiz $quiz): View
    {
        $quizDTO = $this->get(QuizHandler::class)->handleGetQuiz($quiz);

        return View::create($quizDTO, Response::HTTP_OK);
    }

    /**
     * @Rest\Patch("/quizzes/{id}", name="quizzes.quiz.patch")
     *
     * @param Quiz $quiz
     * @param QuizDTO $quizDTO
     *
     * @return View
     */
    public function patchAction(QuizDTO $quizDTO, Quiz $quiz): View
    {
        $quizDTO = $this->get(QuizHandler::class)->handlePatch($quizDTO, $quiz);

        return View::create($quizDTO, Response::HTTP_OK);
    }



    /**
     * @Rest\Post(
     *     "/quizzes",
     *     name="api.quizzes.quiz.post"
     * )
     * @param QuizDTO $quizDTO
     *
     * @return View
     */
    public function createAction(QuizDTO $quizDTO)
    {
        $this->get(QuizHandler::class)
            ->postAction($quizDTO, $this->getUser());

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
            ->handleGetQuizzesByUser($user, $page, $count);

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
    public function getQuizzesByCategoryAction(Request $request, Category $category): View
    {
        $page = $request->get('page') ?: 1;
        $count = $request->get('count') ?: PaginatorManager::PAGE_LIMIT;

        $quizzes = $this->get(QuizHandler::class)
            ->handleGetQuizzesByCategory($category, $page, $count);

        return View::create($quizzes, Response::HTTP_OK);
    }

    /**
     * @Rest\Post(
     *     "/quiz/{quiz_id}/solve" ,
     *     name="api.quiz.solve"
     * )
     * @param Quiz $quiz
     * @param ResultDTO $resultDTO
     *
     * @ParamConverter(
     *     "quiz",
     *     options={"id" = "quiz_id"}
     * )
     * @return View
     */
    public function postSolveQuizAction(ResultDTO $resultDTO, Quiz $quiz): View
    {
        $user = $this->getUser();

        $result = $this->get(QuizHandler::class)
            ->handleSolveQuiz($resultDTO, $quiz, $user);

        return View::create($result, Response::HTTP_CREATED);
    }

}
