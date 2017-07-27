<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\AnswerDTO;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;

class AnswerTransformer
{
    /**
     * @param AnswerDTO $answerDTO
     * @param Question $question
     *
     * @return Answer
     */
    public function transformAnswerDTO(AnswerDTO $answerDTO, Question $question)
    {
        $answer = new Answer();
        $answer->setText($answerDTO->text);
        $answer->setCorrect($answerDTO->correct);
        $answer->setQuestion($question);

        return $answer;
    }
}
