<?php

namespace AdminBundle\Manager;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @return ArrayCollection|array
     */
    public function paginate(Query $query, int $page, int $count = self::PAGE_LIMIT)
    {
        $paginator = new Paginator($query);
        $totalItems = count($paginator);

        $paginator->getQuery()
            ->setFirstResult($count * ($page - 1))
            ->setMaxResults($count);

        return ['paginator' => $paginator, 'totalItems' => $totalItems];
    }

}
