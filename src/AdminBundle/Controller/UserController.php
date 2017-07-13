<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/user",name="admin.user.list")
     *
     */
    public function userListAction(Request $request)
    {
        $page = $request->get('page', 1);

        $users = $this->getDoctrine()->getRepository(User::class)->getAllUsers($page);

        $limit = 19;
        $maxPages = ceil($users->count() / $limit);

        return $this->render('userList/list.html.twig', [
            'users' => $users->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'thisPage' => $page,
        ]);
    }

    /**
     * @param User $user
     *
     * @Route("/user/enable/{user}",name="admin.user.enable")
     *
     *
     */
    public function enableAction(User $user)
    {
        $user->isActive() ? $user->setActive(0) : $user->setActive(1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('admin.user.list');

    }

}
