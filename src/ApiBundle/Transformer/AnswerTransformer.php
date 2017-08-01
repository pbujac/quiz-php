<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\AnswerDTO;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;

class AnswerTransformer
{
    /**
     * @param Answer $answer
     * @param AnswerDTO|null $answerDTO
     *
     * @return AnswerDTO
     */
    public function transform(
        Answer $answer,
        AnswerDTO $answerDTO = null
    ) {
        $answerDTO ?: new AnswerDTO();
        $answerDTO->id = $answer->getId();
        $answerDTO->text = $answer->getText();
        $answerDTO->correct = $answer->isCorrect();

        return $answerDTO;
    }

    /**
     * @param AnswerDTO $answerDTO
     * @param Question $question
     * @param Answer|null $answer
     *
     * @return Answer
     */
    public function reverseTransform(
        AnswerDTO $answerDTO,
        Question $question,
        Answer $answer = null
    ) {
        $answer ?: new Answer();
        $answer->setText($answerDTO->text);
        $answer->setCorrect($answerDTO->correct);
        $answer->setQuestion($question);

        return $answer;
    }
}
