<?php

namespace ApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation("self", href = "expr('/api/question/' ~ object.id)")
 */
class QuestionDTO
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
     * @var $text
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
