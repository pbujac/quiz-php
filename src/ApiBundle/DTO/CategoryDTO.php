<?php

namespace ApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

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
}

