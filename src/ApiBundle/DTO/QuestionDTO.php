<?php

namespace ApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class QuestionDTO
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
     * @var ArrayCollection|AnswerDTO[]
     * @Type("ArrayCollection<ApiBundle\DTO\AnswerDTO>")
     */
    public $answers;
}
