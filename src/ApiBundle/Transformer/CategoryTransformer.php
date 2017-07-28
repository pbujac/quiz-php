<?php

namespace ApiBundle\Transformer;

use AppBundle\Entity\Category;
use ApiBundle\DTO\CategoryDTO;

class CategoryTransformer
{
    public function transformUserDTO(CategoryDTO $categoryDTO)
    {
        $category = new Category();
        $category->setTitle($categoryDTO->title);
        return $category;
    }

    public function transformUserObj(Category $category)
    {
        $categoryDTO = new CategoryDTO();
        $categoryDTO->id = $category->getId();
        $categoryDTO->title = $category->getTitle();

       return $categoryDTO;
    }

}

