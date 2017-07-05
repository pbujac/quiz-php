<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="questions")
 * @ORM\Entity
 */
class Question
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
     * @var Quiz
     *
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="questions")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     */
    private $quiz;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question")
     */
    private $answers;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ResultAnswer", mappedBy="question")
     */
    private $resultAnswers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->resultAnswers = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Quiz
     */
    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    /**
     * @param Quiz $quiz
     */
    public function setQuiz(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnswers(): ArrayCollection
    {
        return $this->answers;
    }

    /**
     * @param ArrayCollection $answers
     */
    public function setAnswers(ArrayCollection $answers)
    {
        $this->answers = $answers;
    }

    /**
     * @return ArrayCollection
     */
    public function getResultAnswers(): ArrayCollection
    {
        return $this->resultAnswers;
    }

    /**
     * @param ArrayCollection $resultAnswers
     */
    public function setResultAnswers(ArrayCollection $resultAnswers)
    {
        $this->resultAnswers = $resultAnswers;
    }


}

