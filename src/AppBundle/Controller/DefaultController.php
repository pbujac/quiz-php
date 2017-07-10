<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $user = new User();
        $user->setUsername("");
        $user->setPassword("");
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('password', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Login'))
            ->getForm();

        return $this->render('default/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
