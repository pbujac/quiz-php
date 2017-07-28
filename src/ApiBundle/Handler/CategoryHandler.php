<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\CategoryDTO;
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
     * @param CategoryDTO $categoryDTO
     */
    public function listCategory(CategoryDTO $categoryDTO)
    {
        $this->em->persist(
            $this->categoryTransformer->transformUserDTO($categoryDTO)
        );
        $this->em->flush();
    }

}
