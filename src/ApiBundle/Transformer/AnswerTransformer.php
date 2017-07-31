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
    public function transform(AnswerDTO $answerDTO, Question $question)
    {
        $answer = new Answer();
        $answer->setText($answerDTO->text);
        $answer->setCorrect($answerDTO->correct);
        $answer->setQuestion($question);

        return $answer;
    }

    /**
     * @param Answer $answer
     *
     * @return AnswerDTO
     */
    public function reverseTransform(Answer $answer)
    {
        $answerDTO = new AnswerDTO();
        $answerDTO->text = $answer->getText();
        $answerDTO->correct = $answer->isCorrect();

        return $answerDTO;
    }
}
