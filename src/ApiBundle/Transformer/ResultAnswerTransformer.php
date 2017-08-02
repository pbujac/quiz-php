<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\ResultAnswerDTO;
use AppBundle\Entity\Answer;
use AppBundle\Entity\ResultAnswer;
use Doctrine\ORM\EntityManagerInterface;

class ResultAnswerTransformer
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var QuestionTransformer */
    private $questionTransformer;

    /** @var AnswerTransformer */
    private $answerTransformer;

    /**
     * @param EntityManagerInterface $em
     * @param QuestionTransformer $questionTransformer
     * @param AnswerTransformer $answerTransformer
     */
    public function __construct(
        EntityManagerInterface $em,
        QuestionTransformer $questionTransformer,
        AnswerTransformer $answerTransformer
    ) {
        $this->em = $em;
        $this->questionTransformer = $questionTransformer;
        $this->answerTransformer = $answerTransformer;
    }

    /**
     * @param ResultAnswerDTO $resultAnswerDTO
     * @param ResultAnswer|null $resultAnswer
     *
     * @return ResultAnswer
     */
    public function reverseTransform(
        ResultAnswerDTO $resultAnswerDTO,
        ResultAnswer $resultAnswer = null
    ): ResultAnswer {
        $resultAnswer = $resultAnswer ?: new ResultAnswer();

        $answer = $this->em->getRepository(Answer::class)
            ->find($resultAnswerDTO->answer->id);

        $resultAnswer->setAnswer($answer);
        $resultAnswer->setQuestion($answer->getQuestion());

        return $resultAnswer;
    }

}
