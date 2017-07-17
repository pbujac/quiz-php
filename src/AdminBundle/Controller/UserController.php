<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\UserType;
use AppBundle\Entity\User;
use AdminBundle\Manager\PaginatorManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    /**
     * @param int $page = 1
     *
     * @return RedirectResponse|Response
     *
     * @Route("/user/list/{page}",name="admin.user.list")
     */
    public function userListAction(int $page = 1)
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->getAllUsersByPage($page);

        $maxPages = ceil($users->count() / PaginatorManager::PAGE_LIMIT);

        return $this->render('admin/user/list.html.twig', [
            'users' => $users->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'currentPage' => $page,
        ]);
    }

    /**
     * @param User $user_id
     *
     * @return RedirectResponse|Response
     * @return  RedirectResponse|Response
     *
     * @Route("/user/{user_id}/enable",name="admin.user.enable")
     */
    public function enableAction(User $user_id)
    {
        $user_id->setActive(!$user_id->isActive());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user_id);
        $em->flush();

        return $this->redirectToRoute('admin.user.list');

    }

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

            $password = $this->get('security.password_encoder')->encodePassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($password);
            $user->setCreatedAtValue();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'notice',
                $user->getUsername() . ' user was added!'
            );

            return $this->redirectToRoute('admin.user.list');
        }

        return $this->render('admin/user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param User $user_id
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/user/edit/{user_id}", name="admin.user.edit")
     */
    public function editAction(User $user_id,Request $request)
    {
        $form = $this->createForm(UserType::class,$user_id);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $this->get('security.password_encoder')->encodePassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($password);
            $user->setCreatedAtValue();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'notice',
                $user->getUsername() . ' user was modified!'
            );

            return $this->redirectToRoute('admin.user.list');
        }

        return $this->render(
            'admin/user/edit.html.twig',
            ['form' => $form->createView()
            ]);
    }
}

