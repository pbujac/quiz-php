<?php

namespace ApiBundle\Controller;

use ApiBundle\DTO\UserDTO;
use ApiBundle\Handler\UserHandler;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/users")
 */
class UserController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     "/{user_id}",
     *     name="api.users.get"
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
     * @Rest\Put(
     *     "/{user_id}",
     *     name="api.users.put"
     * )
     *
     * @param UserDTO $userDTO
     * @param User $user
     *
     * @ParamConverter(
     *     "user",
     *     options={"id" = "user_id"}
     * )
     * @return View
     */
    public function putAction(UserDTO $userDTO, User $user)
    {
        $this->get(UserHandler::class)->handlePutUser($userDTO, $user);

        return View::create(null, Response::HTTP_NO_CONTENT);
    }

}
