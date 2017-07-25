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
 * @Rest\Route("/register",name="api.register")
 */
class RegistrationController extends FOSRestController
{
    /**
     * @Rest\Post()
     *
     * @param RegistrationDTO $registrationDTO
     * @param RegistrationHandler $registrationHandler
     *
     * @ParamConverter(
     *     "registrationDTO",
     *     converter="fos_rest.request_body")
     *
     * @return View
     */
    public function registerAction(RegistrationDTO $registrationDTO , RegistrationHandler $registrationHandler)
    {
        $registrationHandler->handleRegistration($registrationDTO);

        return View::create($registrationDTO,Response::HTTP_OK);
    }

}
