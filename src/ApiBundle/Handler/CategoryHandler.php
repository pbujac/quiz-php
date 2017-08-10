<?php

namespace ApiBundle\Handler;

use ApiBundle\Transformer\CategoryTransformer;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Hateoas\Representation\CollectionRepresentation;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use ApiBundle\Manager\ApiPaginatorManager;
use Hateoas\Representation\PaginatedRepresentation;

class CategoryHandler
{
    /** @var EntityManagerInterface $em */
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
    ) {
        $this->em = $em;
        $this->categoryTransformer = $categoryTransformer;
    }

    /**
     * @param int $page
     * @param int $count
     *
     * @return PaginatedRepresentation
     */
    public function handlePagination(int $page, int $count): PaginatedRepresentation
    {
        $categories = $this->em->getRepository(Category::class)
            ->getCategoriesByPage($page, $count);


        $categoriesDTO = $this->addCategoriesDTO($categories['paginator']);

        $categoriesPagination = $this->getCategoriesPagination($categoriesDTO);

        return ApiPaginatorManager::paginate(
            $categoriesPagination,
            $page,
            'api.categories.list',
            $categories['totalItems'],
            $count
        );
    }

    /**
     * @param Paginator $categories
     *
     * @return ArrayCollection
     */
    public function addCategoriesDTO($categories): ArrayCollection
    {
        $categoriesDTO = new ArrayCollection();

        foreach ($categories as $category) {
            $categoryDTO = $this->categoryTransformer->transform($category);

            $categoriesDTO->add($categoryDTO);
        }

        return $categoriesDTO;
    }

    /**
     * @param ArrayCollection $categoriesDTO
     *
     * @return CollectionRepresentation
     */
    private function getCategoriesPagination(ArrayCollection $categoriesDTO): CollectionRepresentation
    {
        $collectionRepresentation = new CollectionRepresentation(
            $categoriesDTO,
            'categories'
        );

        return $collectionRepresentation;
    }

}
