<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\QuestionDTO;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;
use Doctrine\Common\Collections\ArrayCollection;

class QuestionTransformer
{
    /** @var AnswerTransformer */
    private $transformAnswer;

    /**
     * @param AnswerTransformer $transformAnswer
     */
    public function __construct(AnswerTransformer $transformAnswer)
    {
        $this->transformAnswer = $transformAnswer;
    }

    /**
     * @param Question $question
     *
     * @return QuestionDTO
     */
    public function transform(Question $question)
    {
        $questionDTO = new QuestionDTO();
        $questionDTO->text = $question->getText();

        $questionDTO->answers = new ArrayCollection();
        foreach ($question->getAnswers() as $answer) {
            $questionDTO->answers->add($this->transformAnswer->transform($answer));
        }

        return $questionDTO;
    }

    /**
     * @param QuestionDTO $questionDTO
     * @param Quiz $quiz
     *
     * @return Question
     */
    public function reverseTransform(QuestionDTO $questionDTO, Quiz $quiz)
    {
        $question = new Question();
        $question->setText($questionDTO->text);
        $question->setQuiz($quiz);

        foreach ($questionDTO->answers as $answerDTO) {
            $question->addAnswer(
                $this->transformAnswer->reverseTransform($answerDTO, $question));
        }

        return $question;
    }
}
