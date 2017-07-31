<?php

namespace ApiBundle\DTO;

use AdminBundle\Validator\Constraints\UniqueQuiz;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation("self", href = "expr('/api/quizzes/' ~ object.id)")
 */
class QuizDTO
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
     * @var string
     * @Type("string")
     *
     * @Assert\NotBlank(message="title isn't specified")
     * @Assert\Length(max=255, maxMessage="too long")
     * @UniqueQuiz(message="the quiz with this title already exist")
     */
    public $title;

    /**
     * @Type("ApiBundle\DTO\QuestionDTO")
     */
    public $category;


    /**
     * @var string
     * @Type("string")
     *
     * @Assert\NotBlank(message="description for quiz isn't specified")
     * @Assert\Length(max=5000, maxMessage="too long")
     */
    public $description;

    /**
     * @Type("ApiBundle\DTO\UserDTO")
     */
    public $author;

    /**
     * @var ArrayCollection|QuestionDTO[]
     * @Type("ArrayCollection<ApiBundle\DTO\QuestionDTO>")
     *
     * @Assert\Valid
     */
    public $questions;
}
