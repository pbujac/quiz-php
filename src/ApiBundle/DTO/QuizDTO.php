<?php

namespace ApiBundle\DTO;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class QuizDTO
{
    /**
     * @var string
     * @Type("string")
     */
    private $title;

    /**
     * @var int
     * @Type("int")
     */
    private $category_id;

    /**
     * @var string
     * @Type("string")
     */
    private $description;

    /**
     * @var int
     * @Type("int")
     */
    private $author_id;

    /**
     *
     * @var ArrayCollection|QuestionDTO[]
     *
     * @Type("ArrayCollection<ApiBundle\DTO\QuestionDTO>")
    */
    private $questions;

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
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->category_id;
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

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->author_id;
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
