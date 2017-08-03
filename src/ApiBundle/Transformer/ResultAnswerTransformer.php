<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\ResultAnswerDTO;
use AppBundle\Entity\Answer;
use AppBundle\Entity\ResultAnswer;
use Doctrine\ORM\EntityManagerInterface;

class ResultAnswerTransformer implements TransformerInterface
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
    public function reverseTransform($resultAnswerDTO, $resultAnswer = null): ResultAnswer
    {
        $resultAnswer = $resultAnswer ?: new ResultAnswer();

        $answer = $this->em->getRepository(Answer::class)
            ->find($resultAnswerDTO->answer->id);

        $resultAnswer->setAnswer($answer);
        $resultAnswer->setQuestion($answer->getQuestion());

        return $resultAnswer;
    }

    /**
     * @param ResultAnswer $resultAnswer
     *
     * @return ResultAnswerDTO
     */
    public function transform($resultAnswer): ResultAnswerDTO
    {
        $resultAnswerDTO = new ResultAnswerDTO();
        $resultAnswerDTO->id = $resultAnswer->getId();
        $resultAnswerDTO->question = $this->questionTransformer->transform($resultAnswer->getQuestion());
        $resultAnswerDTO->answer = $this->answerTransformer->transform($resultAnswer->getAnswer());

        return $resultAnswerDTO;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return ResultAnswer::class;
    }
}
