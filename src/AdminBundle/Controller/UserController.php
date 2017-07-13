<?php

namespace AdminBundle\Controller;

use AdminBundle\Manager\PaginatorManager;
use AppBundle\Entity\User;
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
     * @Route("/user/{page}",name="admin.user.list")
     */
    public function userListAction(Request $request, int $page = 1)
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
}
