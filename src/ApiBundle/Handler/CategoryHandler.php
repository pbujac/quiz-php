<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\CategoryDTO;
use ApiBundle\Transformer\CategoryTransformer;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use AdminBundle\Manager\PaginatorManager;



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
    )
    {
        $this->em = $em;
        $this->categoryTransformer = $categoryTransformer;

    }

    /**
     * @param int $page
     *
     * @return PaginatedRepresentation
     */
    public function handlerGetByPage(int $page){

        $categories=$this->em->getRepository(Category::class)
            ->findAll();

        $collectionDTO =new ArrayCollection();
        foreach ($categories as $category) {
            $categoryDTO = $this->categoryTransformer->reverseTransform($category);

            $collectionDTO[]= $categoryDTO;
        }

        return $this->paginate($collectionDTO,$page);
    }


    /**
     * @param ArrayCollection|CategoryDTO[] $collectionDTO
     * @param int $page
     *
     * @return PaginatedRepresentation
     */
    private function paginate(ArrayCollection $collectionDTO,int $page)
    {
        $maxPages = ceil($collectionDTO->count() / PaginatorManager::PAGE_LIMIT);

        $collectionRepresentation = new CollectionRepresentation(
            $collectionDTO,
            'categories'
        );

        return new PaginatedRepresentation($collectionRepresentation,
            "api_category_get",
            array(),
            $page,
            PaginatorManager::PAGE_LIMIT,
            $maxPages,
            'page',
            'limit',
            false,
            $collectionDTO->count()
        );
    }

}
