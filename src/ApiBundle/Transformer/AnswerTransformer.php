<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\AnswerDTO;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;

class AnswerTransformer implements TransformerInterface
{
    /**
     * @param Answer $answer
     *
     * @return AnswerDTO
     */
    public function transform($answer): AnswerDTO
    {
        $answerDTO = new AnswerDTO();
        $answerDTO->text = $answer->getText();
        $answerDTO->correct = $answer->isCorrect();

        return $answerDTO;
    }

    /**
     * @param AnswerDTO $answerDTO
     * @param null $answer
     *
     * @return Answer
     */
    public function reverseTransform($answerDTO, $answer = null): Answer
    {
        $answer = new Answer();
        $answer->setText($answerDTO->text);
        $answer->setCorrect($answerDTO->correct);

        return $answer;
    }

    public function getEntityClass(): string
    {
        return Answer::class;
    }

}
