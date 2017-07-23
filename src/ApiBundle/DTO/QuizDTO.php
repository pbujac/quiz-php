<?php
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * @ORM\Table(name="quizzes")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\QuizRepository")
 *
 * @ExclusionPolicy("all")
 */
class QuizDTO
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @Expose
     */
    private $title;

//    /**
//     * @var Category
//     *
//     * @ORM\ManyToOne(targetEntity="Category", inversedBy="quizzes")
//     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
//     */
//    private $category;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @Expose
     */
    private $createdAt;

//    /**
//     * @ORM\ManyToOne(targetEntity="User", inversedBy="quizzes")
//     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
//     */
//    private $author;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Expose
     */
    private $description;

}
