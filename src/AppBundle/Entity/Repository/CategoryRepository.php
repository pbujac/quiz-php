<?php

namespace AppBundle\Entity\Repository;

use AdminBundle\Manager\PaginatorManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CategoryRepository extends EntityRepository
{
    /**
     * @param int $page
     * @param int $count
     *
     * @return ArrayCollection|array
     */
    public function getCategoriesByPage(int $page, int $count = PaginatorManager::PAGE_LIMIT)
    {
        $paginator = new PaginatorManager();

        $query = $this->createQueryBuilder('c')
            ->getQuery();

        return $paginator->paginate($query, $page, $count);
    }

}
