<?php

namespace ApiBundle\Controller;

use ApiBundle\DTO\LoginDTO;
use ApiBundle\Handler\LoginHandler;
use ApiBundle\Transformer\UserTransformer;
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
     * @Rest\Get("/{user_id}")
     *
     * @param User $user
     * @ParamConverter("user", options={"id" = "user_id"})
     *
     * @return View
     */
    public function getByIdAction(User $user)
    {
        $userDTO = $this->get(UserTransformer::class)->transformUserObj($user);

        return View::create($userDTO, Response::HTTP_OK);
    }

}
