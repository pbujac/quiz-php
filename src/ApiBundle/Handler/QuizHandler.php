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
            ->getQuizByFilterAndPage($filter, $page);

        return $this->tranformQuizzes($quizzes);
    }

    /**
     * @param $quizzes
     * @return ArrayCollection
     */
    public function tranformQuizzes($quizzes): ArrayCollection
    {
        $quizzesDTO = new ArrayCollection();
        foreach ($quizzes as $quiz) {
            $quizzesDTO->add(
                $this->quizTransformer->reverseTransform($quiz)
            );
        }
        return $quizzesDTO;
    }

//    public function handleQuizByFilter($filter)
//    {
//        $qb = $this->createQueryBuilder('q')
//            ->addSelect('c, a')
//            ->join('q.category', 'c')
//            ->join('q.author', 'a');
//
//
//        return $quizzes ;
//    }
}
