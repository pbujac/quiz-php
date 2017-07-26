<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\AnswerDTO;
use AppBundle\Entity\Answer;

class AnswerTransformer
{
    /**
     * @param AnswerDTO $answerDTO
     *
     * @return Answer
     */
    public function transformAnswerDTO(AnswerDTO $answerDTO){
        $answer = new Answer();
        $answer->setText($answerDTO->getText());
        $answer->setCorrect($answerDTO->getText());

        return $answer;
    }
}
