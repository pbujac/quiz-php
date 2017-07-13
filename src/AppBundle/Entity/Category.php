<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(type="string", length=45)
     */
    private $title;

    /**
     * @var ArrayCollection|Quiz[]
     *
     * @ORM\OneToMany(targetEntity="Quiz", mappedBy="category")
     */
    private $quizzes;

    public function __construct()
    {
        $this->quizzes = new ArrayCollection();
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
     * @param Quiz $quiz
     *
     * @return Category
     */
    public function addQuiz(Quiz $quiz)
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes->add($quiz);
        }
        return $this;
    }

    /**
     * @param Quiz $quiz
     *
     */
    public function removeQuiz(Quiz $quiz)
    {
        $this->quizzes->removeElement($quiz);
    }

    /**
     * @return ArrayCollection|Quiz[]
     */
    public function getQuizzes()
    {
        return $this->quizzes;
    }
}

