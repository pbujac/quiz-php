<?php

namespace ApiBundle\Transformer;

use AppBundle\Entity\Category;
use ApiBundle\DTO\CategoryDTO;

class CategoryTransformer implements TransformerInterface
{
    /**
     * @param Category $category
     *
     * @return CategoryDTO
     */
    public function transform($category): CategoryDTO
    {
        $categoryDTO = new CategoryDTO();
        $categoryDTO->id = $category->getId();
        $categoryDTO->title = $category->getTitle();

        return $categoryDTO;
    }

    /**
     * @param CategoryDTO $categoryDTO
     * @param Category|null $category
     *
     * @return Category
     */
    public function reverseTransform($categoryDTO, $category = null): Category
    {
        $category = $category ?: new Category();
        $category->setTitle($categoryDTO->title);

        return $category;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return Category::class;
    }
}

