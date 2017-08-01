<?php

namespace ApiBundle\DTO;

use AdminBundle\Validator\Constraints\UniqueQuiz;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *     "self",
 *     href = "expr('/api/v1/quizzes/' ~ object.id)"
 * )
 */
class QuizDTO
{
    /**
     * @Type("int")
     *
     * @var int
     */
    public $id;

    /**
     *
     * @Type("string")
     *
     * @Assert\NotBlank(message="Title isn't specified")
     * @Assert\Length(max=255, maxMessage="Title is too long")
     * @UniqueQuiz(message="The quiz with this title already exist")
     *
     * @var string
     */
    public $title;

    /**
     * @Type("ApiBundle\DTO\CategoryDTO")
     *
     * @var CategoryDTO
     */
    public $category;

    /**
     * @Type("ApiBundle\DTO\UserDTO")
     *
     * @var UserDTO
     */
    public $author;

    /**
     * @Type("int")
     *
     * @var int
     */
    public $createdAt;

    /**
     * @Type("string")
     *
     * @Assert\NotBlank(message="Description for quiz isn't specified")
     * @Assert\Length(max=5000, maxMessage="Description is too long")
     *
     * @var string
     */
    public $description;

    /**
     * @Type("ArrayCollection<ApiBundle\DTO\QuestionDTO>")
     *
     * @Assert\Valid
     *
     * @var ArrayCollection|QuestionDTO[]
     */
    public $questions;

}
