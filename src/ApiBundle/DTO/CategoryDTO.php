<?php

namespace ApiBundle\DTO;

use AppBundle\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *     "self",
 *     href = "expr('/api/categories/' ~ object.id)"
 * )
 */
class CategoryDTO
{
    /**
     * @Type("int")
     *
     * @Assert\NotBlank()
     *
     * @var int
     */
    public $id;

    /**
     * @Type("string")
     *
     * @Assert\NotBlank
     *
     * @var string
     */
    public $title;

}

