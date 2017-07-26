<?php

namespace ApiBundle\Controller;

use ApiBundle\Handler\RegistrationHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\DTO\RegistrationDTO ;

/**
 * @Rest\Route("/register/user",name="api.register.user")
 */
class RegisterUserController extends FOSRestController
{
    /**
     * @Rest\Post()
     *
     * @param RegistrationDTO $registrationDTO
     *
     * @ParamConverter(
     *     "registrationDTO",
     *     converter="fos_rest.request_body")
     *
     * @return View
     */
    public function indexAction(RegistrationDTO $registrationDTO)
    {
        $this->get(RegistrationHandler::class)->handleRegistration($registrationDTO);

        return View::create($registrationDTO,Response::HTTP_ACCEPTED);
    }

}
