<?php

namespace ApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use Hateoas\Configuration\Annotation as Hateoas;

class AnswerDTO
{
    /**
     * @Type("int")
     *
     * @var int
     */
    public $id;

    /**
     * @Type("string")
     *
     * @Assert\NotBlank(message="text for question isn't specified")
     * @Assert\Length(max=5000, maxMessage="too long")
     *
     * @var $text
     */
    public $text;

    /**
     * @Type("boolean")
     *
     * @var $correct
     */
    public $correct;
}
