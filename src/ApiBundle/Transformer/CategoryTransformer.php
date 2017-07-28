<?php

namespace ApiBundle\Transformer;

use AppBundle\Entity\Category;
use ApiBundle\DTO\CategoryDTO;

class CategoryTransformer
{
    public function transformCategoryDTO(CategoryDTO $categoryDTO)
    {
        $category = new Category();
        $category->setTitle($categoryDTO->title);
        return $category;
    }

    public function transformCategoryObj(Category $category)
    {
        $categoryDTO = new CategoryDTO();
        $categoryDTO->title = $category->getTitle();
        $categoryDTO->id = $category->getId();


       return $categoryDTO;
    }

}

