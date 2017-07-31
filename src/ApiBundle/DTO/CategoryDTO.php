<?php

namespace ApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

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
