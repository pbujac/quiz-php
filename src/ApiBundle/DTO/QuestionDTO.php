<?php

namespace ApiBundle\DTO;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class QuestionDTO
{
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
     * @return AnswerDTO[]|ArrayCollection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param AnswerDTO $answerDTO
     *
     * @return QuestionDTO
     */
    public function addAnswerDTO(AnswerDTO $answerDTO)
    {
        if (!$this->answers->contains($answerDTO)) {
            $this->answers->add($answerDTO);
        }
        return $this;
    }
}
