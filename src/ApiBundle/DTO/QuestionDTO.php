<?php

namespace ApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class QuestionDTO
{
    /**
     * @var int
     * @Type("int")
     */
    public $id;

    /**
     * @var string
     * @Type("string")
     *
     * @Assert\NotBlank(message="text for question isn't specified")
     * @Assert\Length(max=5000, maxMessage="too long")
     */
    public $text;

    /**
     * @var ArrayCollection|AnswerDTO[]
     * @Type("ArrayCollection<ApiBundle\DTO\AnswerDTO>")
     *
     * @Assert\Valid
     */
    public $answers;

}
