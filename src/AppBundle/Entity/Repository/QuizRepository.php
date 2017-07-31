<?php

namespace AppBundle\Entity\Repository;

use AdminBundle\Manager\PaginatorManager;
use AppBundle\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityRepository;

class QuizRepository extends EntityRepository
{
    /**
     * @param string $filter
     * @param int $page
     *
     * @return Paginator
     */
    public function getQuizByFilter(?string $filter = null, int $page)
    {
        $paginator = new PaginatorManager();

        $qb = $this->createQueryBuilder('q')
            ->addSelect('c, a')
            ->join('q.category', 'c')
            ->join('q.author', 'a');

        if ($filter) {
            $qb->where('q.title LIKE :filter')
                ->orWhere('c.title  LIKE :filter')
                ->setParameter('filter', '%' . $filter . '%');
        }

        return $paginator->paginate($qb->getQuery(), $page);
    }

    /**
     * @param User $user
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function getQuizzesByAuthorAndPage(User $user, int $page, int $count)
    {
        $paginator = new PaginatorManager();

        $query = $this->createQueryBuilder('quiz')
            ->join('quiz.author', 'a')
            ->where('a.id = :userId')
            ->setParameter('userId', $user->getId())
            ->getQuery();

        return $paginator->paginate($query, $page, $count);
    }
}
