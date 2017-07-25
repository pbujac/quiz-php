<?php

namespace ApiBundle\Controller;

use ApiBundle\Handler\RegistrationHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\DTO\RegistrationDTO ;

/**
 * Class RegistrationController
 *
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
     * @return View
     */
    public function registerAction(RegistrationDTO $registrationDTO , RegistrationHandler $registrationHandler)
    {
        $registrationHandler->registrationHandler();

        return View::create($registrationDTO,Response::HTTP_OK);
    }

}
