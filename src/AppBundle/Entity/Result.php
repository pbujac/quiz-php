<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Result
 *
 * @ORM\Table(name="results")
 * @ORM\Entity
 */
class Result
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="results")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var Quiz
     *
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="results")
     * @ORM\JoinColumn(name="quiz_id", referencedColumnName="id")
     */
    private $quiz;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $finished;

    /**
     * @var ArrayCollection|ResultAnswer[]
     *
     * @ORM\OneToMany(targetEntity="ResultAnswer", mappedBy="result")
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
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
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score)
    {
        $this->score = $score;
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->finished;
    }

    /**
     * @param bool $finished
     */
    public function setFinished(bool $finished)
    {
        $this->finished = $finished;
    }

    /**
     * @param ResultAnswer $resultAnswer
     *
     * @return Result
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

