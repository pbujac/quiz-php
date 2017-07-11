<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ListOfUsersController extends DefaultController
{
    /**
     * @Route("/userList/{page}",name="user_index")
     */
    public function indexAction($page=1)
    {
        $repository = $this->getDoctrine()
            ->getRepository(User::class);
        $users = $repository->getAllUsers($page); // Returns 19 users out of 20

        $limit = 19;
        $maxPages = ceil($users->count() / $limit);
        $thisPage = $page;

        return $this->render('userList/list.html.twig', [
            'users' => $users->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'thisPage' => $thisPage,
        ]);
    }

}
