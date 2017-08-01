<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\QuestionDTO;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;

class QuestionTransformer
{
    /** @var AnswerTransformer */
    private $answerTransformer;

    /**
     * @param AnswerTransformer $answerTransformer
     */
    public function __construct(AnswerTransformer $answerTransformer)
    {
        $this->answerTransformer = $answerTransformer;
    }

    /**
     * @param QuestionDTO $questionDTO
     * @param Quiz $quiz
     *
     * @return Question
     */
    public function reverseTransformQuestion(QuestionDTO $questionDTO, Quiz $quiz)
    {
        $question = new Question();
        $question->setText($questionDTO->text);
        $question->setQuiz($quiz);

        foreach ($questionDTO->answers as $answerDTO) {
            $question->addAnswer(
                $this->answerTransformer->reverseTransformAnswer($answerDTO, $question));
        }

        return $question;
    }
}
