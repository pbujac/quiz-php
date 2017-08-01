<?php

namespace AppBundle\Entity\Repository;

use AdminBundle\Manager\PaginatorManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CategoryRepository extends EntityRepository
{
    /**
     * @param int $page
     *
     * @return Paginator
     */
    public function getCategoriesByPage(int $page)
    {
        $paginator = new PaginatorManager();

        $query = $this->createQueryBuilder('c')
            ->getQuery();

        return $paginator->paginate($query, $page);
    }

}
