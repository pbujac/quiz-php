<?php

namespace ApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *     "self",
 *     href = "expr('/api/questions/' ~ object.id)"
 * )
 */
class QuestionDTO
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
     * @Type("ArrayCollection<ApiBundle\DTO\AnswerDTO>")
     *
     * @Assert\Valid
     *
     * @var ArrayCollection|AnswerDTO[]
     */
    public $answers;
}
