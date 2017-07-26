<?php

namespace ApiBundle\DTO;

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
     * @var CategoryDTO
     * @Type("ApiBundle\DTO\CategoryDTO")
     */
    private $category;

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
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category)
    {
        $this->category = $category;
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
     * @return QuestionDTO[]|ArrayCollection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

//    /**
//     * @param QuestionDTO $questionDTO
//     *
//     * @return QuizDTO
//     */
//    public function addQuestionDTO(QuestionDTO $questionDTO)
//    {
//        if (!$this->questions->contains($questionDTO)) {
//            $this->questions->add($questionDTO);
//        }
//        return $this;
//    }
}
