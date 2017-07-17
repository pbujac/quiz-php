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
     *
     * @return Paginator
     */
    public function paginate(Query $query, int $page)
    {
        $paginator = new Paginator($query);
        $paginator
            ->getQuery()
            ->setFirstResult(self::PAGE_LIMIT * ($page - 1))
            ->setMaxResults(self::PAGE_LIMIT);

        return $paginator;
    }
}
