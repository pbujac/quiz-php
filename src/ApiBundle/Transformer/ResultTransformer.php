<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\ResultDTO;
use AppBundle\Entity\Result;
use Doctrine\Common\Collections\ArrayCollection;

class ResultTransformer implements TransformerInterface
{
    /** @var QuizTransformer */
    private $quizTransformer;

    /** @var UserTransformer */
    private $userTransformer;

    /** @var ResultAnswerTransformer */
    private $resultAnswerTransformer;

    /** @var QuestionTransformer */
    private $questionTransformer;

    /** @var AnswerTransformer */
    private $answerTransformer;

    /**
     * @param QuizTransformer $quizTransformer
     * @param UserTransformer $userTransformer
     * @param ResultAnswerTransformer $resultAnswerTransformer
     * @param QuestionTransformer $questionTransformer
     * @param AnswerTransformer $answerTransformer
     */
    public function __construct(
        QuizTransformer $quizTransformer,
        UserTransformer $userTransformer,
        ResultAnswerTransformer $resultAnswerTransformer,
        QuestionTransformer $questionTransformer,
        AnswerTransformer $answerTransformer
    ) {
        $this->quizTransformer = $quizTransformer;
        $this->userTransformer = $userTransformer;
        $this->resultAnswerTransformer = $resultAnswerTransformer;
        $this->questionTransformer = $questionTransformer;
        $this->answerTransformer = $answerTransformer;
    }

    /**
     * @param ResultDTO $resultDTO
     * @param Result|null $result
     *
     * @return Result
     */
    public function reverseTransform($resultDTO, $result = null): Result
    {
        $result = $result ?: new Result();

        $finished = $this->checkFinishedQuiz($result);
        $result->setFinished($finished);

        $this->addResultAnswers($resultDTO, $result);

        return $result;
    }

    /**
     * @param Result $result
     *
     * @return ResultDTO
     */
    public function transform($result): ResultDTO
    {
        $resultDTO = new ResultDTO();
        $resultDTO->id = $result->getId();
        $resultDTO->quiz = $this->quizTransformer->transform($result->getQuiz());
        $resultDTO->user = $this->userTransformer->transform($result->getUser());
        $resultDTO->finished = $result->isFinished();
        $resultDTO->score = $result->getScore();
        $resultDTO->createdAt = $result->getCreatedAt()->getTimestamp();
        $this->addResultAnswersDTO($result, $resultDTO);

        return $resultDTO;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return Result::class;
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

    /**
     * @param Result $result
     * @param ResultDTO $resultDTO
     */
    public function addResultAnswersDTO(Result $result, ResultDTO $resultDTO): void
    {
        $resultDTO->resultAnswers = new ArrayCollection();

        foreach ($result->getResultAnswers() as $resultAnswer) {
            $resultAnswerDTO = $this->resultAnswerTransformer->transform($resultAnswer);

            $resultDTO->resultAnswers->add($resultAnswerDTO);
        }
    }

}
