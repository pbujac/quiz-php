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
        $questionDTO->id = $question->getId();
        $questionDTO->text = $question->getText();
        $this->addAnswers($question, $questionDTO);

        return $questionDTO;
    }

    /**
     * @param QuestionDTO $questionDTO
     * @param Quiz $quiz
     * @param Question|null $question
     *
     * @return Question
     */
    public function reverseTransform(QuestionDTO $questionDTO, Quiz $quiz, Question $question = null)
    {
        $question ?: new Question();
        $question->setText($questionDTO->text);
        $question->setQuiz($quiz);
        $this->addAnswersDTO($questionDTO, $question);

        return $question;
    }

    /**
     * @param QuestionDTO $questionDTO
     * @param Question $question
     */
    public function addAnswersDTO(QuestionDTO $questionDTO, Question $question)
    {
        foreach ($questionDTO->answers as $answerDTO) {
            $question->addAnswer(
                $this->transformAnswer->reverseTransform(
                    $answerDTO,
                    $question
                )
            );
        }
    }

    /**
     * @param Question $question
     * @param QuestionDTO $questionDTO
     */
    public function addAnswers(Question $question, QuestionDTO $questionDTO)
    {
        $questionDTO->answers = new ArrayCollection();

        foreach ($question->getAnswers() as $answer) {
            $questionDTO->answers->add(
                $this->transformAnswer->transform($answer)
            );
        }
    }
}
