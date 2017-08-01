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
    public function handlePagination(int $page, int $count)
    {
        $categories = $this->em->getRepository(Category::class)
            ->getCategoriesByPage($page, $count);

        $categoriesDTO = $this->addCategoriesDTO($categories);

        $paginator = new ApiPaginatorManager();
        $collectionRepresentation = $this->getCategoriesCollectionRepresentation(
            $categoriesDTO
        );

        return $paginator->paginate(
            $collectionRepresentation,
            $page,
            'api.categories.list'
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
            $categoriesDTO->add(
                $this->categoryTransformer->transform($category)
            );
        }

        return $categoriesDTO;
    }

    /**
     * @param ArrayCollection $categoriesDTO
     *
     * @return CollectionRepresentation
     */
    private function getCategoriesCollectionRepresentation(
        ArrayCollection $categoriesDTO
    ) {
        $collectionRepresentation = new CollectionRepresentation(
            $categoriesDTO,
            'categories'
        );

        return $collectionRepresentation;
    }

}
