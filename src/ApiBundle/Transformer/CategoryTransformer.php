<?php

namespace ApiBundle\Transformer;

use AppBundle\Entity\Category;
use ApiBundle\DTO\CategoryDTO;

class CategoryTransformer
{
    public function transform(Category $category)
    {
        $categoryDTO = new CategoryDTO();
        $categoryDTO->title = $category->getTitle();
        return $categoryDTO;
    }

}

