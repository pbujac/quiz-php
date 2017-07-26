<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\QuestionDTO;
use AppBundle\Entity\Question;

class QuestionTransformer
{
    /**
     * @param QuestionDTO $questionDTO*
     * @return Question
     */
    public function transformQuestionDTO(QuestionDTO $questionDTO){
        $question = new Question();
        $question->setText($questionDTO->getText());

        $answer = new AnswerTransformer();
        foreach ($questionDTO->getAnswers() as $answerDTO)
        {
            $question->addAnswer($answer->transformAnswerDTO($answerDTO));
        }

        return $question;
    }
}
