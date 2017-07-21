<?php

namespace ApiBundle\Controller ;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use ApiBundle\DTO\RegisterDTO;

class RegisterController extends FOSRestController
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Rest\Route("/api/register", name="api.user.register")
     */
    public function registrationAction(Request $request)
    {
        $user= new RegisterDTO();
        $user->setUsername('username');
        $user->setPassword('password');
        $user->setFirstName('firstName');
        $user->setLastName('lastName');

       dump($user);

        $view=$this->view($user,200)
            ->setTemplate("ApiBundle:Resources:views:user:register:register.html.twig")
            ->setTemplateVar('registration');

        return $this->handleView($view);

    }

    /**
     * @return RedirectResponse|Response
     */
    public function redirectAction()
    {
        $view=$this->routeRedirectView('user.page',301);

        return $this->handleView($view);
    }

}
