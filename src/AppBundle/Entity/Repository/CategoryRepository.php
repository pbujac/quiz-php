<?php

namespace AppBundle\Entity\Repository;

use AdminBundle\Manager\PaginatorManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CategoryRepository extends EntityRepository
{
    /**
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function getCategoriesByPage(int $page, int $count)
    {
        $paginator = new PaginatorManager();

        $query = $this->createQueryBuilder('c')
            ->getQuery();

        return $paginator->paginate($query, $page, $count);
    }

}
