<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class UserController extends DefaultController
{
    /**
     * @Route("/userList/{page}",name="user_list_page")
     */
    public function userListAction($page=1)
    {
        $users = $this->getDoctrine()->getRepository(User::class)->getAllUsers($page);

        $limit = 19;
        $maxPages = ceil($users->count() / $limit);

        return $this->render('userList/list.html.twig', [
            'users' => $users->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'thisPage' => $page,
        ]);
    }
}
