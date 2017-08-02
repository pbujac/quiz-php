<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\DTO\ResultAnswerDTO;
use ApiBundle\DTO\ResultDTO;
use AppBundle\Entity\Answer;
use AppBundle\Entity\Category;
use AppBundle\Entity\Quiz;
use AppBundle\Entity\Result;
use AppBundle\Entity\ResultAnswer;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @param ResultAnswer $resultAnswer
     *
     * @return ResultAnswerDTO
     */
    public function transform(ResultAnswer $resultAnswer)
    {
        $resultAnswerDTO = new ResultAnswerDTO();

        $resultAnswerDTO->question = $this->questionTransformer->transform(
            $resultAnswer->getQuestion()
        );
        $resultAnswerDTO->answer = $this->answerTransformer->transform(
            $resultAnswer->getAnswer()
        );

        return $resultAnswerDTO;
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
