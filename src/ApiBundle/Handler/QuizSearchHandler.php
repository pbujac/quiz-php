<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\Transformer\QuizTransformer;
use AppBundle\Entity\Quiz;

class QuizSearchHandler extends QuizTransformer
{
    /**
     * @param Quiz $quiz
     *
     * @return QuizDTO
     */
    public function handleQuizSearch(Quiz $quiz)
    {


        return $this->reverseTransform($quiz);
    }

    public function handleQuizByFilter($filter)
    {
        $qb = $this->createQueryBuilder('q')
            ->addSelect('c, a')
            ->join('q.category', 'c')
            ->join('q.author', 'a');


        return $quizzes ;
    }
}
