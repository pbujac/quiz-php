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
     * @var ArrayCollection|Answer[]
     *
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question")
     */
    private $answers;

    /**
     * @var ArrayCollection|ResultAnswer[]
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
     * @param Answer $answer
     *
     * @return Question
     */
    public function addAnswer(Answer $answer)
    {
        if (!$this->resultAnswers->contains($answer)) {
            $this->resultAnswers->add($answer);
        }
        return $this;
    }

    /**
     * @param Answer $answer
     */
    public function removeAnswer(Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * @return ArrayCollection|Answer[]
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param ResultAnswer $answer
     *
     * @return Question
     */
    public function addResultAnswer(ResultAnswer $answer)
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
        }
        return $this;
    }

    /**
     * @param ResultAnswer $resultAnswer
     */
    public function removeResultAnswer(ResultAnswer $resultAnswer)
    {
        $this->resultAnswers->removeElement($resultAnswer);
    }

    /**
     * @return ArrayCollection|ResultAnswer[]
     */
    public function getResultAnswers()
    {
        return $this->resultAnswers;
    }


}

