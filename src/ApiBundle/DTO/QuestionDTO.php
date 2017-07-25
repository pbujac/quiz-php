<?php

namespace ApiBundle\DTO;

use AppBundle\Entity\Question;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class QuestionDTO
{
    /**
     * @var int
     * @Type("int")
     */
    private $id;

    /**
     * @var $text
     * @Type("string")
     */
    private $text;

    /**
     *
     * @var ArrayCollection|AnswerDTO[]
     *
     * @Type("ArrayCollection<ApiBundle\DTO\AnswerDTO>")
     */
    private $answers;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return Question
     */
    public function addQuestion()
    {
        $question = new Question();
        $question->setText($this->getText());

        return $question;
    }
}
