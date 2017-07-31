<?php

namespace ApiBundle\Controller;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\Handler\QuizHandler;
use ApiBundle\Manager\UserTokenManager;
use AppBundle\Entity\User;
use Firebase\JWT\JWT;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends FOSRestController
{
    /**
     * @Rest\Post("/quizzes", name="quizzes")
     *
     * @param QuizDTO $quizDTO
     *
     * @return View
     */
    public function createAction(QuizDTO $quizDTO)
    {
        $this->get(QuizHandler::class)->postAction($quizDTO);

        return View::create($quizDTO, Response::HTTP_CREATED);
    }

    /**
     *
     * @Rest\Route(
     *     "/user/quizzes" ,
     *     name="api.user.quizzes"
     * )
     * @Rest\Get()
     *
     * @return View
     */
    public function getQuizzesByUserAction()
    {
        $quizzes = $this->get(QuizHandler::class)
            ->handleGetQuizzesByUser(
                $this->getUser()
            );

        return View::create($quizzes, Response::HTTP_OK);
    }

}
