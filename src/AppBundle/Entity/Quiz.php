<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="quizzes")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\QuizRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Quiz
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="quizzes")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="quizzes")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var ArrayCollection|Question[]
     *
     * @ORM\OneToMany(targetEntity="Question", mappedBy="quiz", cascade={"persist", "remove"})
     */
    private $questions;

    /**
     * @var ArrayCollection|Result[]
     *
     * @ORM\OneToMany(targetEntity="Result", mappedBy="quiz",  cascade={"persist", "remove"})
     */
    private $results;


    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->results = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @param Question $question
     *
     * @return Quiz
     */
    public function addQuestion(Question $question)
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }
        return $this;
    }

    /**
     * @param Question $question
     */
    public function removeQuestion(Question $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * @return ArrayCollection|Question[]
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * @param Result $result
     *
     * @return Quiz
     */
    public function addResult(Result $result)
    {
        if (!$this->results->contains($result)) {
            $this->results->add($result);
        }
        return $this;
    }

    /**
     * @param Result $result
     */
    public function removeResult(Result $result)
    {
        $this->results->removeElement($result);
    }

    /**
     * @return ArrayCollection|Result[]
     */
    public function getResults()
    {
        return $this->results;
    }
}

