<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\Transformer\QuizTransformer;
use AppBundle\Entity\Quiz;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class QuizHandler
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var QuizTransformer */
    private $quizTransformer;

    /**
     * @param EntityManagerInterface $em
     * @param QuizTransformer $quizTransformer
     */
    public function __construct(
        EntityManagerInterface $em,
        QuizTransformer $quizTransformer
    )
    {
        $this->em = $em;
        $this->quizTransformer = $quizTransformer;
    }

    /**
     * @param int $page
     * @param string|null $filter
     *
     * @return ArrayCollection|QuizDTO[]
     */
    public function searchByFilter(int $page, string $filter = null)
    {
        $quizzes = $this->em->getRepository(Quiz::class)
            ->getQuizByQueryAndPage($filter, $page);

        return $this->transformQuizzes($quizzes);
    }

    /**
     * @param $quizzes
     * @return ArrayCollection
     */
    public function transformQuizzes($quizzes): ArrayCollection
    {
        $quizzesDTO = new ArrayCollection();
        foreach ($quizzes as $quiz) {
            $quizzesDTO->add(
                $this->quizTransformer->transform($quiz)
            );
        }
        return $quizzesDTO;
    }

}
