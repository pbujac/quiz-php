<?php

namespace AppBundle\Entity\Repository;

use AdminBundle\Manager\PaginatorManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityRepository;

class QuizRepository extends EntityRepository
{
    /**
     * @param int $page
     *
     * @return Paginator
     */
    public function getAllQuizzesByPage($page)
    {
        $paginator = new PaginatorManager();

        $query = $this->createQueryBuilder('q')
            ->getQuery();

        return $paginator->paginate($query, $page);
    }

    /**
     * @param string $filter
     */
    public function getQuizByFilter($filter,$page)
    {
        $paginator = new PaginatorManager();

        $qb = $this->createQueryBuilder('quiz')
            ->getQuery();

        if ($filter) {

            $qb->andWhere('quiz.title LIKE :filter OR quiz.category LIKE :filter')
                ->setParameter('filter', '%'.$filter.'%');
        }
        return $paginator->paginate($qb, $page);
    }


}
