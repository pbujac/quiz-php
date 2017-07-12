<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/userList/{page}",name="user_list_page")
     *
     */
    public function userListAction($page=1)
    {
        $users = $this->getDoctrine()->getRepository(User::class)->getAllUsers($page);

        $limit = 19;
        $maxPages = ceil($users->count() / $limit);

        return $this->render('AdminBundle:userList:list.html.twig', [
            'users' => $users->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'thisPage' => $page,
        ]);
    }
}
