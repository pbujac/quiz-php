<?php

namespace AdminBundle\Controller;

use AdminBundle\Manager\PaginatorManager;
use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @Route("/categories/{page}", name="categories_page")
     */
    public function allCategoriesByPageAction($page)
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->getCategoriesByPage($page);

        $maxPages = ceil($categories->count() / PaginatorManager::PAGE_LIMIT);

        return $this->render('AdminBundle:admin/category:categories-list.html.twig', [
            'categories' => $categories->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'currentPage' => $page,
        ]);
    }
}
