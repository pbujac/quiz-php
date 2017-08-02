<?php

namespace ApiBundle\Controller;

use AdminBundle\Manager\PaginatorManager;
use ApiBundle\Handler\CategoryHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

/**
 * @Rest\Route("/categories")
 */
class CategoryController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     name="api.categories.list"
     * )
     * @param Request $request
     *
     * @return View
     */
    public function getAction(Request $request)
    {
        $page = $request->get('page') ?: 1;
        $count = $request->get('count') ?: PaginatorManager::PAGE_LIMIT;

        $categories = $this->get(CategoryHandler::class)->handlePagination($page, $count);

        return View::create($categories, Response::HTTP_OK);
    }
}
