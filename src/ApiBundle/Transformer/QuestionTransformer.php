<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\QuestionDTO;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;
use Doctrine\Common\Collections\ArrayCollection;

class QuestionTransformer implements TransformerInterface
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
    public function transform($question): QuestionDTO
    {
        $questionDTO = new QuestionDTO();
        $questionDTO->text = $question->getText();

        $questionDTO->answers = new ArrayCollection();
        foreach ($question->getAnswers() as $answer) {
            $questionDTO->answers->add(
                $this->transformAnswer->transform($answer));
        }

        return $questionDTO;
    }

    /**
     * @param QuestionDTO $questionDTO
     * @param null $question
     *
     * @return Question
     */
    public function reverseTransform($questionDTO, $question = null): Question
    {
        $question = $question ?: new Question();
        $question->setText($questionDTO->text);

        foreach ($questionDTO->answers as $answerDTO) {
            $question->addAnswer(
                $this->transformAnswer->reverseTransform($answerDTO));
        }

        return $question;
    }

    public function getEntityClass(): string
    {
        return Question::class;
    }

}
