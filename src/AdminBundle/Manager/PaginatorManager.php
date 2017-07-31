<?php

namespace AdminBundle\Manager;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginatorManager
{
    const PAGE_LIMIT = 19;

    /**
     * @param Query $query
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function paginate(
        Query $query,
        int $page,
        int $count = self::PAGE_LIMIT
    ) {
        $paginator = new Paginator($query);

        $paginator->getQuery()
            ->setFirstResult($count * ($page - 1))
            ->setMaxResults($count);

        return $paginator;
    }

}
