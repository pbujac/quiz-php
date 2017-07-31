<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuizDTO;
use AppBundle\Entity\Quiz;
//use Doctrine\ORM\EntityManagerInterface;
use ApiBundle\Transformer\QuizTransformer;

class QuizSearchHandler extends QuizTransformer
{
//    /** @var EntityManagerInterface $em */
//    private $em;
//
//    /**
//     * @param EntityManagerInterface $em
//     */
//    public function __construct(
//        EntityManagerInterface $em
//    )
//    {
//        $this->em = $em;
//    }

    /**
     * @param Quiz $quiz
     * @param string $filter
     *
     * @return QuizDTO
     */
    public function handleQuizSearch(Quiz $quiz , string $filter)
    {


        return $this->reverseTransform($quiz);
    }


}
