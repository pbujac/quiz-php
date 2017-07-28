<?php

namespace ApiBundle\Controller;

use ApiBundle\Handler\UserHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\DTO\UserDTO ;

/**
 * @Rest\Route("/register/user",name="api.register.user")
 */
class RegisterUserController extends FOSRestController
{
    /**
     * @Rest\Post()
     *
     * @param UserDTO $registrationDTO
     *
     * @ParamConverter(
     *     "registrationDTO",
     *     converter="fos_rest.request_body")
     *
     * @return View
     */
    public function indexAction(UserDTO $registrationDTO)
    {
        $this->get(UserHandler::class)->handleRegistration($registrationDTO);

        return View::create($registrationDTO,Response::HTTP_CREATED);
    }

}
