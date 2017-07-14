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

        if($filter) {
            $qb = $this->createQueryBuilder('q')
                ->join('q.category', 'category')
                ->where('q.title =:filter')
                ->orWhere('q.category  = :filter')
                ->setParameter('filter', $filter)
                ->getQuery();
        }
        else
        {
            $qb = $this->createQueryBuilder('q')
            ->getQuery();
        }

        return $paginator->paginate($qb, $page);
    }


}
