<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\CategoryDTO;
use AppBundle\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use ApiBundle\Transformer\CategoryTransformer;

class CategoryHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

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
     * @param Category $category
     */
    public function listCategory(Category $category)
    {
        $this->em->getRepository(Category::class)->findAll();
        $this->categoryTransformer->transformCategoryObj($category);

        $this->em->flush();
    }

}
