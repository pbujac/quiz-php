<?php

namespace ApiBundle\Controller;

use ApiBundle\DTO\CategoryDTO;
use Doctrine\ORM\EntityManagerInterface;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;
use ApiBundle\Transformer\CategoryTransformer;
use AppBundle\Entity\Category;
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
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var CategoryTransformer
     */
    private $categoryTransformer;

    /**
     * @param EntityManagerInterface $em
     * @param CategoryTransformer $categoryTransformer
     */
    public function __construct(
        EntityManagerInterface $em,
        CategoryTransformer $categoryTransformer
    )
    {
        $this->em = $em;
        $this->categoryTransformer = $categoryTransformer;

    }

    /**
     * @Rest\Get()
     */
    public function getByPageAction()
    {
        $categoryDTO = new CategoryDTO();
        $categories = $this->em->getRepository(Category::class)->findAll();
        foreach ($categories as $category) {
            $categoryDTO = $this->categoryTransformer->transformCategoryObj($category);
        }

        $paginatedCollection = new PaginatedRepresentation(
            new CollectionRepresentation([$categoryDTO],
                'categories', // embedded rel
                'categories'  // xml element name
            ),
            "api_category_getbypage", // route
            array(), // route parameters
            1,       // page number
            19,      // limit
            3,       // total pages
            'page',  // page route parameter name, optional, defaults to 'page'
            'limit', // limit route parameter name, optional, defaults to 'limit'
            false,   // generate relative URIs, optional, defaults to `false`
            75       // total collection size, optional, defaults to `null`
        );

        return View::create($paginatedCollection, Response::HTTP_OK);
    }

}
