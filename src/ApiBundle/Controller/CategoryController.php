<?php

namespace ApiBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;
use ApiBundle\Transformer\CategoryTransformer;
use AppBundle\Entity\Category;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AdminBundle\Manager\PaginatorManager;


/**
 * @Rest\Route("/categories")
 */
class CategoryController extends FOSRestController
{
    /**
     * @var CategoryTransformer
     */
    private $categoryTransformer;

    /**
     * @param CategoryTransformer $categoryTransformer
     */
    public function __construct(CategoryTransformer $categoryTransformer)
    {
        $this->categoryTransformer = $categoryTransformer;
    }

    /**
     * @Rest\Get("/list/{page}")
     *
     */
    public function getByPageAction(int $page)
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->getCategoriesByPage($page);

        $maxPages = ceil($categories->count() / PaginatorManager::PAGE_LIMIT);

        $collectionDTO = new ArrayCollection();

        foreach ($categories as $category) {
            $categoryDTO = $this->categoryTransformer->reverseTransform($category);

            $collectionDTO[] = $categoryDTO;
        }

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation([
                $collectionDTO
            ],
                'categories'
            ),
            "api_category_getbypage",
            array(),
            $page,
            PaginatorManager::PAGE_LIMIT,
            $maxPages,
            'page',
            'limit',
            false,
            $categories->count()
        );

        return View::create($paginatedCollection, Response::HTTP_OK);
    }

}
