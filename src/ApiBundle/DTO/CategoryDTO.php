<?php

namespace ApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation("self", href = "expr('/api/categories/' ~ object.id)")
 */
class CategoryDTO
{
    /**
     * @Type("int")
     * @var int
     *
     * @Assert\NotBlank
     */
    public $id;

    /**
     * @Type("string")
     * @var string
     */
    public $title;
}
