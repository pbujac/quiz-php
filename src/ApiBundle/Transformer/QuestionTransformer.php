<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\QuestionDTO;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Question;
use Doctrine\Common\Collections\ArrayCollection;

class QuestionTransformer implements TransformerInterface
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
     * @param Question $question
     *
     * @return QuestionDTO
     */
    public function transform($question): QuestionDTO
    {
        $questionDTO = new QuestionDTO();
        $questionDTO->id = $question->getId();
        $questionDTO->text = $question->getText();
        $this->addAnswers($questionDTO, $question);

        return $questionDTO;
    }

    /**
     * @param QuestionDTO $questionDTO
     * @param Question|null $question
     *
     * @return Question
     */
    public function reverseTransform($questionDTO, $question = null): Question
    {
        $question = $question ?: new Question();
        $question->setText($questionDTO->text);
        $this->addAnswers($questionDTO, $question);

        return $question;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return Question::class;
    }

    /**
     * @param QuestionDTO $questionDTO
     * @param Question $question
     */
    public function addAnswers(QuestionDTO $questionDTO, Question $question): void
    {
        foreach ($questionDTO->answers as $answerDTO) {
            $answer = new Answer();
            $answer->setQuestion($question);
            $answer = $this->answerTransformer->reverseTransform($answerDTO, $answer);

            $question->addAnswer($answer);
        }
    }

    /**
     * @param QuestionDTO $questionDTO
     * @param Question $question
     */
    public function addAnswersDTO(QuestionDTO $questionDTO, Question $question): void
    {
        $questionDTO->answers = new ArrayCollection();

        foreach ($question->getAnswers() as $answer) {
            $answerDTO = $this->answerTransformer->transform($answer);

            $questionDTO->answers->add($answerDTO);
        }
    }

}
