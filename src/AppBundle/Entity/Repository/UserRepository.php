<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param int $currentPage
     *
     * @return Paginator
     */
    public function getAllUsers($currentPage = 1)
    {
        $query = $this->createQueryBuilder('u')
            ->orderBy('u.createdAt', 'DESC')
            ->getQuery();

        return $this->paginate($query, $currentPage);
    }

    /**
     * @param Query $dql
     * @param int $page
     * @param int $limit
     *
     * @return Paginator
     */
    public function paginate($dql, $page = 1, $limit = 19)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }

}
