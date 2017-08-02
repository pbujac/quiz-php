<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\ResultDTO;
use AppBundle\Entity\Result;

class ResultTransformer
{
    /** @var ResultAnswerTransformer */
    private $resultAnswerTransformer;

    /**
     * @param ResultAnswerTransformer $resultAnswerTransformer
     */
    public function __construct(ResultAnswerTransformer $resultAnswerTransformer)
    {
        $this->resultAnswerTransformer = $resultAnswerTransformer;
    }

    /**
     * @param ResultDTO $resultDTO
     * @param Result|null $result
     *
     * @return Result
     */
    public function reverseTransform(ResultDTO $resultDTO, Result $result): Result
    {
        $finished = $this->checkFinishedQuiz($result);
        $result->setFinished($finished);

        $this->addResultAnswers($resultDTO, $result);

        return $result;
    }

    /**
     * @param Result $result
     *
     * @return bool
     */
    public function checkFinishedQuiz(Result $result): bool
    {
        $finished = false;
        $totalQuestions = $result->getQuiz()->getQuestions()->count();
        $answeredQuestions = $result->getResultAnswers()->count();

        if ($totalQuestions === $answeredQuestions) {
            $finished = true;
        }

        return $finished;
    }

    /**
     * @param ResultDTO $resultDTO
     * @param Result $result
     */
    public function addResultAnswers(ResultDTO $resultDTO, Result $result): void
    {
        foreach ($resultDTO->resultAnswers as $resultAnswerDTO) {

            $resultAnswer = $this->resultAnswerTransformer->reverseTransform($resultAnswerDTO);
            $resultAnswer->setResult($result);

            $result->addResultAnswer($resultAnswer);
        }
    }

}
