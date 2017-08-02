<?php

namespace ApiBundle\Transformer;

use AppBundle\Entity\Category;
use ApiBundle\DTO\CategoryDTO;

class CategoryTransformer
{
    /**
     * @param Category $category
     *
     * @return CategoryDTO
     */
    public function transform(Category $category): CategoryDTO
    {
        $categoryDTO = new CategoryDTO();
        $categoryDTO->id = $category->getId();
        $categoryDTO->title = $category->getTitle();

        return $categoryDTO;
    }

    /**
     * @param CategoryDTO $categoryDTO
     * @param Category $category
     *
     * @return Category
     */
    public function reverseTransform(CategoryDTO $categoryDTO, Category $category = null): Category
    {
        $category = $category ?: new Category();
        $category->setTitle($categoryDTO->title);

        return $category;
    }

}

