<?php

namespace ApiBundle\DTO;

use AdminBundle\Validator\Constraints\UniqueQuiz;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class QuizDTO
{
    /**
     * @var string
     * @Type("string")
     * @Assert\NotBlank
     * @Assert\Length(max=255)
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
     * @Assert\NotBlank
     * @Assert\Length(max=5000)
     */
    private $description;

    /**
     * @var int
     * @Type("int")
     */
    private $author_id;

    /**
     * @var ArrayCollection|QuestionDTO[]
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
}
