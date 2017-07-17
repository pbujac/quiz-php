<?php

namespace AppBundle\Entity\Repository;

use AdminBundle\Manager\PaginatorManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityRepository;

class QuizRepository extends EntityRepository
{
    /**
     * @param string $filter
     * @param int $page
     *
     * @return Paginator
     */
    public function getQuizByFilter($filter = '', $page)
    {
        $paginator = new PaginatorManager();

        $qb = $this->createQueryBuilder('q')
            ->addSelect('c, a')
            ->join('q.category', 'c')
            ->join('q.author', 'a');

        if ($filter) {
            $qb->where('q.title LIKE :filter')
                ->orWhere('c.title  = :filter')
                ->setParameter('filter', $filter);
        }

        return $paginator->paginate($qb->getQuery(), $page);
    }


}
