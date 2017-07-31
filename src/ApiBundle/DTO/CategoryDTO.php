<?php

namespace ApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

class CategoryDTO
{
    /**
     * @var string
     * @Type("string")
     *
     * @Assert\NotBlank(message="title isn't specified")
     */
    public $title;
}
