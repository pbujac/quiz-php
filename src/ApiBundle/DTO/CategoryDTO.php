<?php

namespace ApiBundle\DTO;

use AppBundle\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *     "categories",href = "expr('/api/categories/' ~ object.getId())")
 */
class CategoryDTO
{
    /**
     * @Type("int")
     * @Assert\NotBlank()
     * @var int
     */
    public $id;

    /**
     * @Assert\NotBlank
     * @Type("string")
     * @var string
     */
    public $title;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        $category = new Category();
        $category->setTitle($this->title);

        return $category;
    }

}

