<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Repository\UserRepository;


class ListOfUsersController extends DefaultController
{/**
 * @Route("/userList/{page}",name="user_list",requirements={"page": "\d+"})
 */
    public function listAction($page)
    {
        $repository = $this->getDoctrine()
            ->getRepository(User::class);
        $users = $repository->findAll();

        return $this->render(
            'userList/list.html.twig',
            array('users' => $users)
        );

    }

    /**
     * @Route("/userList/{page}",name="user_index")
     */
    public function indexAction($page=1)
    {
        $repository = $this->getDoctrine()
            ->getRepository(User::class);
        $users = $repository->getAllUsers($page); // Returns 19 users out of 20


        # Total fetched (ie: `19` users)
        $totalUsersReturned = $users->getIterator()->count();

        # Count of ALL users (ie: `20` users)
        $totalUsers = $users->count();

        # ArrayIterator
        $iterator = $users->getIterator();

        return $this->render('userList/list2.html.twig', compact('categories', 'maxPages', 'thisPage'));
    }


}
