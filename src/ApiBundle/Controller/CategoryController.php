<?php

namespace ApiBundle\Controller;

use ApiBundle\CategoryHandler;
use ApiBundle\DTO\CategoryDTO;
use ApiBundle\Transformer\CategoryTransformer;
use AppBundle\Entity\Category;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Rest\Route("/categories")
 */
class CategoryController extends FOSRestController
{
    /**
     * @Rest\Get("/{category_id}")
     *
     * @param Category $category
     * @ParamConverter("category", options={"id" = "category_id"})
     *
     * @return View
     */
    public function getByIdAction(Category $category)
    {
        $categoryDTO = $this->get(CategoryTransformer::class)->transformCategoryObj($category);

        return View::create($categoryDTO, Response::HTTP_OK);
    }
}
