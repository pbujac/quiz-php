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
    public function transform($category): CategoryDTO
    {
        $categoryDTO = new CategoryDTO();
        $categoryDTO->title = $category->getTitle();

        return $categoryDTO;
    }

}

