<?php

namespace ApiBundle\DTO;

use AdminBundle\Validator\Constraints\UniqueQuiz;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class QuizDTO
{
    /**
     * @var string
     * @Type("string")
     *
     * @Assert\NotBlank(message="title isn't specified")
     * @Assert\Length(max=255, maxMessage="too long")
     */
    public $title;

    /**
     * @var int
     * @Type("int")
     */
    public $categoryId;

    /**
     * @var string
     * @Type("string")
     *
     * @Assert\NotBlank(message="description for quiz isn't specified")
     * @Assert\Length(max=5000, maxMessage="too long")
     */
    public $description;

    /**
     * @var int
     * @Type("int")
     */
    public $authorId;

    /**
     * @var ArrayCollection|QuestionDTO[]
     * @Type("ArrayCollection<ApiBundle\DTO\QuestionDTO>")
     *
     * @Assert\Valid
     */
    public $questions;
}
