<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Repository\UserRepository;


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

        $limit = 5;
        $maxPages = ceil($users->count() / $limit);
        $thisPage = $page;

        return $this->render('userList/list2.html.twig', [
            'users' => $users->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'thisPage' => $thisPage,
        ]);
    }


}
