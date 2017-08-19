<?php

namespace ApiBundle\Controller;

use ApiBundle\DTO\UserDTO;
use ApiBundle\Handler\UserHandler;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/users")
 */
class UserController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     "/{user_id}",
     *     name="api.users.user.get"
     * )
     *
     * @param User $user
     *
     * @ParamConverter(
     *     "user",
     *     options={"id" = "user_id"}
     * )
     * @return View
     */
    public function getByIdAction(User $user)
    {
        $userDTO = $this->get(UserHandler::class)->handleGetUser($user);

        return View::create($userDTO, Response::HTTP_OK);
    }

    /**
     * @Rest\Get()
     *
     * @param Request $request
     *
     * @return View
     */
    public function getByUsernameAction(Request $request)
    {
        $username = $request->get('username') ?: '';
        $userDTO = $this->get(UserHandler::class)->handleGetUserByUsername($username);

        return View::create($userDTO, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Post("/register")
     *
     * @param UserDTO $userDTO
     *
     * @return View
     */
    public function postAction(UserDTO $userDTO)
    {
        $userDTO = $this->get(UserHandler::class)->handleRegistration($userDTO);

        return View::create($userDTO, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put(
     *     "/{user_id}",
     *     name="api.users.user.put"
     * )
     * @param UserDTO $userDTO
     * @param User $user
     *
     * @ParamConverter(
     *     "user",
     *     options={"id" = "user_id"}
     * )
     *
     * @return View
     */
    public function putAction(UserDTO $userDTO, User $user)
    {
        $this->get(UserHandler::class)->handlePutUser($userDTO, $user);

        return View::create(null, Response::HTTP_NO_CONTENT);
    }

}
