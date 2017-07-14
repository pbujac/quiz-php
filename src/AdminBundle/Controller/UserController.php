<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\UserType;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/user/create", name="admin.user.create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(UserType::class, new User());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setCreatedAtValue();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'notice',
                $user->getUsername() . ' user was added!'
            );


            return $this->redirectToRoute('admin.user.create');
        }

        return $this->render(
            'admin/user/create.html.twig',
            ['form' => $form->createView()
            ]);
    }

    /**
     * @param User $user
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/user/edit/{user}", name="admin.user.edit")
     */
    public function editAction(User $user,Request $request)
    {
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setCreatedAtValue();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'notice',
                $user->getUsername() . ' user was modified!'
            );


            return $this->redirectToRoute('admin.user.edit');
        }

        return $this->render(
            'admin/user/edit.html.twig',
            ['form' => $form->createView()
            ]);
    }

}

