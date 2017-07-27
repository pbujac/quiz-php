<?php

namespace ApiBundle\DTO;

use AdminBundle\Validator\Constraints\NotEmptyAnswer;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

class AnswerDTO
{
    /**
     * @var $text
     * @Type("string")
     *
     * @Assert\NotBlank
     * @Assert\Length(max=5000)
     */
    public $text;

    /**
     * @var $correct
     * @Type("boolean")
     *
     * @NotEmptyAnswer()
     */
    public $correct;
}
