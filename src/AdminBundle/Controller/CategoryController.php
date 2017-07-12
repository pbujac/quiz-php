<?php

namespace AdminBundle\Controller;

use AdminBundle\Manager\PaginatorManager;
use AppBundle\Entity\Category;
use AdminBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @param int $page
     * @return RedirectResponse|Response
     *
     * @Route("/category/list/{page}", name="admin.category.list")
     */
    public function listAction(int $page)
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->getCategoriesByPage($page);

        $maxPages = ceil($categories->count() / PaginatorManager::PAGE_LIMIT);

        return $this->render('admin/category/list.html.twig', [
            'categories' => $categories->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'currentPage' => $page,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/category/create", name="admin.category.create")
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl(
                'admin.category.list',
                ['page' => 1]
            ));

        }
        return $this->render('admin/category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
