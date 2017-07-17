<?php

namespace AppBundle\Entity\Repository;

use AdminBundle\Manager\PaginatorManager;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param int $page
     *
     * @return Paginator
     */
    public function getAllUsersByPage(int $page)
    {
        $paginator = new PaginatorManager();

        $query = $this->createQueryBuilder('u')
            ->getQuery();

        return $paginator->paginate($query, $page);
    }
}
