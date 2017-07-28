<?php

namespace ApiBundle\Transformer;

use AppBundle\Entity\Category;
use ApiBundle\DTO\CategoryDTO;

class CategoryTransformer
{
    public function CategoryTransform(Category $category)
    {
        $categoryDTO = new CategoryDTO();
        $categoryDTO->setTitle($category->getTitle());

        return $categoryDTO;
    }

}

