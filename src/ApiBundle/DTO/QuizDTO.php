<?php

namespace ApiBundle\DTO;

use AppBundle\Entity\Quiz;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class QuizDTO
{
    /**
     * @var int
     * @Type("int")
     */
    private $id;

    /**
     * @var string
     * @Type("string")
     */
    private $title;

    /**
     * @var string
     * @Type("string")
     */
    private $description;

    /**
     *
     * @var ArrayCollection|QuestionDTO[]
     *
     * @Type("ArrayCollection<ApiBundle\DTO\QuestionDTO>")
    */
    private $questions;

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

//    /**
//     * @return QuestionDTO[]|ArrayCollection
//     */
//    public function getQuestions()
//    {
//        return $this->questions;
//    }
//
//    /**
//     * @param QuestionDTO[]|ArrayCollection $questions
//     */
//    public function setQuestions($questions)
//    {
//        $this->questions = $questions;
//    }

    /**
     * @return Quiz
     */
    public function addQuiz()
    {
        $quiz = new Quiz();
        $quiz->setTitle($this->getTitle());
        $quiz->setDescription($this->getDescription());

        return $quiz;
    }
}
