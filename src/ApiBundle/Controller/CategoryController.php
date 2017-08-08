<?php

namespace ApiBundle\Controller;

use ApiBundle\Handler\CategoryHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/categories")
 */
class CategoryController extends FOSRestController
{
    /**
     * @Rest\Get("/list/{page}")
     *
     * @param int $page
     *
     * @return View
     */
    public function getAction(int $page)
    {
        $categories = $this->get(CategoryHandler::class)
            ->handlePagination($page);

        return View::create($categories, Response::HTTP_OK);
    }

}

