<?php

namespace ApiBundle\Controller;

use ApiBundle\Handler\CategoryHandler;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

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
            ->handlerGetByPage($page);

        return View::create($categories, Response::HTTP_OK);
    }

}

