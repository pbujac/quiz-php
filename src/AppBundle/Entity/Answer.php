<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answers")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\AnswerRepository")
 */
class Answer
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
     * @var Question
     *
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $correct;

    /**
     * @var ArrayCollection|ResultAnswer[]
     *
     * @ORM\OneToMany(targetEntity="ResultAnswer", mappedBy="answer")
     */
    private $resultAnswers;

    public function __construct()
    {
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
     * @return Question
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

    /**
     * @param Question $question
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;
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
     * @return bool
     */
    public function isCorrect(): bool
    {
        return $this->correct;
    }

    /**
     * @param bool $correct
     */
    public function setCorrect(bool $correct)
    {
        $this->correct = $correct;
    }

    /**
     * @param ResultAnswer $resultAnswer
     *
     * @return Answer
     */
    public function addResultAnswer(ResultAnswer $resultAnswer)
    {
        if (!$this->resultAnswers->contains($resultAnswer)) {
            $this->resultAnswers->add($resultAnswer);
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

