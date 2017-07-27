<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\QuestionDTO;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;

class QuestionTransformer
{
    /** @var AnswerTransformer */
    private $transformAnswer;

    /**
     * QuestionTransformer constructor.
     * @param AnswerTransformer $transformAnswer
     */
    public function __construct(AnswerTransformer $transformAnswer)
    {
        $this->transformAnswer = $transformAnswer;
    }

    /**
     * @param QuestionDTO $questionDTO
     * @param Quiz $quiz
     *
     * @return Question
     */
    public function transformQuestionDTO(QuestionDTO $questionDTO,Quiz $quiz){
        $question = new Question();
        $question->setText($questionDTO->getText());
        $question->setQuiz($quiz);

        foreach ($questionDTO->getAnswers() as $answerDTO)
        {
            $question->addAnswer($this->transformAnswer->transformAnswerDTO($answerDTO,$question));
        }

        return $question;
    }
}
