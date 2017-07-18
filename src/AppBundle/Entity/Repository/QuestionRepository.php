<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository
{
    public function countQuestionsByQuizId(int $quizId)
    {
        return $this->createQueryBuilder('question')
            ->select('count(question.id)')
            ->join('question.quiz', 'quiz')
            ->where('quiz.id = :quizId')
            ->setParameter('quizId', $quizId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
