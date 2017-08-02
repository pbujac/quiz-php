<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\DTO\ResultAnswerDTO;
use ApiBundle\DTO\ResultDTO;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Category;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;
use AppBundle\Entity\Result;
use AppBundle\Entity\ResultAnswer;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class ResultTransformer
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var QuestionTransformer */
    private $transformQuestion;

    /** @var UserTransformer */
    private $userTransformer;

    /** @var CategoryTransformer */
    private $categoryTransformer;

    /** @var ResultAnswerTransformer */
    private $resultAnswerTransformer;


    /** @var AnswerTransformer */
    private $answerTransformer;

    /**
     * ResultTransformer constructor.
     * @param EntityManagerInterface $em
     * @param QuestionTransformer $transformQuestion
     * @param UserTransformer $userTransformer
     * @param CategoryTransformer $categoryTransformer
     * @param ResultAnswerTransformer $resultAnswerTransformer
     * @param AnswerTransformer $answerTransformer
     */
    public function __construct(
        EntityManagerInterface $em,
        QuestionTransformer $transformQuestion,
        UserTransformer $userTransformer,
        CategoryTransformer $categoryTransformer,
        ResultAnswerTransformer $resultAnswerTransformer,
        AnswerTransformer $answerTransformer
    ) {
        $this->em = $em;
        $this->transformQuestion = $transformQuestion;
        $this->userTransformer = $userTransformer;
        $this->categoryTransformer = $categoryTransformer;
        $this->resultAnswerTransformer = $resultAnswerTransformer;
        $this->answerTransformer = $answerTransformer;
    }


    /**
     * @param Result $result
     *
     * @return ResultDTO
     */
    public function transform(Result $result): ResultDTO
    {
        $resultDTO = new ResultDTO();
        $resultDTO->id = $result->getId();

        return $resultDTO;
    }

    /**
     * @param ResultDTO $resultDTO
     * @param Result|null $result
     *
     * @return Result
     */
    public function reverseTransform(
        ResultDTO $resultDTO,
        Result $result = null
    ) {
        $result = $result ?: new Result();

        $this->addResultAnswers($result, $resultDTO);
        $this->checkFinishedQuiz($result);

        return $result;
    }

    /**
     * @param ResultDTO $resultDTO
     * @param Result $result
     */
    public function addResultAnswers(Result $result, ResultDTO $resultDTO): void
    {
        foreach ($resultDTO->resultAnswers as $resultAnswer) {

            $resultAnswer = $this->resultAnswerTransformer->reverseTransform($resultAnswer);
            $resultAnswer->setResult($result);
            $result->addResultAnswer($resultAnswer);
        }
    }

    /**
     * @param Result $result
     */
    public function checkFinishedQuiz(Result $result)
    {
        $totalQuestions = $result->getQuiz()->getQuestions()->count();
        $answeredQuestions = $result->getResultAnswers()->count();

        if ($totalQuestions === $answeredQuestions) {
            $result->setFinished(true);
        } else {
            $result->setFinished(false);
        }
    }

}
