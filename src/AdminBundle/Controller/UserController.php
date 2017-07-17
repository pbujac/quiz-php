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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

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
     * @param User $user
     *
     * @return RedirectResponse|Response
     *
     * @Route("/user/{user}/enable",name="admin.user.enable")
     */
    public function enableAction(User $user)
    {
        $user->setActive(!$user->isActive());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('admin.user.list');

    }

    /**
     * @param Request $request
     * @param UserPasswordEncoder $passwordEncoder
     *
     * @return RedirectResponse|Response
     *
     * @Route("/user/create", name="admin.user.create")
     */
    public function createAction(Request $request, UserPasswordEncoder $passwordEncoder)
    {
        $form = $this->createForm(UserType::class, new User());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
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
}
