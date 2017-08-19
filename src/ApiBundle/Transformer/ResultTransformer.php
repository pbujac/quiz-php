<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\AnswerDTO;
use ApiBundle\DTO\ResultAnswerDTO;
use ApiBundle\DTO\ResultDTO;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Result;
use AppBundle\Entity\ResultAnswer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class ResultTransformer implements TransformerInterface
{
    /** @var EntityManagerInterface $em */
    private $em;

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
     * @param EntityManagerInterface $em
     * @param QuizTransformer $quizTransformer
     * @param UserTransformer $userTransformer
     * @param ResultAnswerTransformer $resultAnswerTransformer
     * @param QuestionTransformer $questionTransformer
     * @param AnswerTransformer $answerTransformer
     */
    public function __construct(
        EntityManagerInterface $em,
        QuizTransformer $quizTransformer,
        UserTransformer $userTransformer,
        ResultAnswerTransformer $resultAnswerTransformer,
        QuestionTransformer $questionTransformer,
        AnswerTransformer $answerTransformer
    ) {
        $this->em = $em;
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

            $this->addAnswers($result, $resultAnswerDTO->answers);
        }
    }

    /**
     * @param Result $result
     * @param ArrayCollection|AnswerDTO[] $answersDTO
     */
    public function addAnswers(Result $result, ArrayCollection $answersDTO)
    {
        foreach ($answersDTO as $answerDTO) {

            $answer = $this->em->getRepository(Answer::class)
                ->find($answerDTO->id);

            $resultAnswer = new ResultAnswer();
            $resultAnswer->setResult($result);
            $resultAnswer->setAnswer($answer);
            $resultAnswer->setQuestion($answer->getQuestion());

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

            $checkExistQuestion = $this->groupAnswersByQuestion($resultDTO->resultAnswers, $resultAnswerDTO);

            if (!$checkExistQuestion) {
                $resultDTO->resultAnswers->add($resultAnswerDTO);
            }
        }
    }

    /**
     * @param ArrayCollection|ResultAnswerDTO[] $resultAnswersDTO
     * @param ResultAnswerDTO $resultAnswerDTO
     *
     * @return bool
     */
    private function groupAnswersByQuestion(ArrayCollection $resultAnswersDTO, ResultAnswerDTO $resultAnswerDTO)
    {
        foreach ($resultAnswersDTO as $rA) {

            if ($rA->question->id === $resultAnswerDTO->question->id) {
                $rA->answers = new ArrayCollection(
                    array_merge($rA->answers->toArray(), $resultAnswerDTO->answers->toArray())
                );

                return true;
            }
        }

        return false;
    }
}
