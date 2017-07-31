<?php

namespace ApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

class AnswerDTO
{
    /**
     * @var string
     * @Type("string")
     *
     * @Assert\NotBlank(message="text for question isn't specified")
     * @Assert\Length(max=5000, maxMessage="too long")
     */
    public $text;

    /**
     * @var bool
     * @Type("boolean")
     */
    public $correct;
}
