<?php

namespace ApiBundle\Controller ;

use AdminBundle\Form\UserType;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use ApiBundle\DTO\RegisterDTO;
use Symfony\Component\HttpKernel\Tests\Controller;

class RegisterController extends Controller
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Rest\Route("/api/register", name="user.register")
     */
    public function registrationAction(Request $request)
    {
        $form = $this->createForm(UserType::class, new User())
            ->setUsername('username','text')
            ->setPassword('password','text')
            ->setFirstName('firstName','text')
            ->setLastName('lastName','text')
            ->getForm();
        ;
        $view=$this->view($form,200)
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
