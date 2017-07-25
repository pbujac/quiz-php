<?php

namespace ApiBundle\DTO;

use AppBundle\Entity\Answer;
use JMS\Serializer\Annotation\Type;

class AnswerDTO
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
     * @var $correct
     * @Type("boolean")
     */
    private $correct;

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
    public function getCorrect()
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
     * @return Answer
     */
    public function addAnswer()
    {
        $answer = new Answer();
        $answer->setText($this->getText());
        $answer->setCorrect($this->getCorrect());

        return $answer;
    }
}
