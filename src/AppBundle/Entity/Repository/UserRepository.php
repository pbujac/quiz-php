<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * getAllUsers() method
     *
     * @param integer $currentPage The current page (passed from controller)
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getAllUsers($currentPage = 1)
    {
        $query = $this->createQueryBuilder('u')
            ->orderBy('u.createdAt', 'DESC')
            ->getQuery();

        $paginator = $this->paginate($query, $currentPage);

        return $paginator;
    }

    /**
     * @param Query $dql   DQL Query Object
     * @param integer            $page  Current page (defaults to 1)
     * @param integer            $limit The total number per page (defaults to 19)
     *
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function paginate($dql, $page = 1, $limit = 19)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }

}
