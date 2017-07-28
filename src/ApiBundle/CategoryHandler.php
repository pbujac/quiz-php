<?php

namespace ApiBundle;

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
     * CategoryHandler constructor.
     * @param $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }

    public function getList( )
    {
        $categories = $this->em->getRepository(Category::class)->findAll();
    }
}

