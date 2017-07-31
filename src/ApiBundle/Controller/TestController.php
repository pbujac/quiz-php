<?php

namespace ApiBundle\Controller;

use ApiBundle\Handler\UserHandler;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class TestController extends FOSRestController
{
    /**
     *
     * @Rest\Route(
     *     "/user/{user_id}/quizzes"
     * )
     * @Rest\Get()
     *
     * @param User $user
     *
     * @ParamConverter(
     *     "user",
     *     options={"id" = "user_id"}
     * )
     *
     * @return View
     */
    public function getQuizzesByUserAction(User $user)
    {
        $userDTO = $this->get(UserHandler::class)->handleGetUser($user);

        return View::create($userDTO, Response::HTTP_OK);
    }

}
