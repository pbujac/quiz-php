<?php

namespace AppBundle\Entity\Repository;

use AdminBundle\Manager\PaginatorManager;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ResultRepository extends EntityRepository
{
    /**
     * @param User $user
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function getQuizzesByUserAndPage(User $user, int $page, int $count)
    {
        $paginator = new PaginatorManager();

        $query = $this->createQueryBuilder('result')
            ->where('result.user = :user')
            ->setParameter('user', $user)
            ->getQuery();

        return $paginator->paginate($query, $page, $count);
    }
}
