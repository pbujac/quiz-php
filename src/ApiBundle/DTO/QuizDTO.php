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
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    public $title;

    /**
     * @var int
     * @Type("int")
     */
    public $category_id;

    /**
     * @var string
     * @Type("string")
     *
     * @Assert\NotBlank
     * @Assert\Length(max=5000)
     */
    public $description;

    /**
     * @var int
     * @Type("int")
     */
    public $author_id;

    /**
     * @var ArrayCollection|QuestionDTO[]
     * @Type("ArrayCollection<ApiBundle\DTO\QuestionDTO>")
     */
    public $questions;
}
