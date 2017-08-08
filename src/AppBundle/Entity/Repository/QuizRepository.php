<?php

namespace AppBundle\Entity\Repository;

use AdminBundle\Manager\PaginatorManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class QuizRepository extends EntityRepository
{
    /**
     * @param string $filter
     * @param int $page
     *
     * @return Paginator
     */
    public function getQuizByFilterAndPage(?string $filter = null, int $page = 1)
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
     * @param array $filter
     * @param int $page
     *
     * @return Paginator
     */
    public function getQuizByQueryAndPage(array $filter, int $page = 1)
    {
        $paginator = new PaginatorManager();

        $qb = $this->createQueryBuilder('q')
            ->addSelect('c, a')
            ->join('q.category', 'c')
            ->join('q.author', 'a');

        if (isset($filter['title']) ?? null) {
            $qb->orWhere('q.title LIKE :title')
                ->setParameter('title', '%' . $filter['title'] . '%');
        }

        if (isset($filter['description']) ?? null) {
            $qb->orWhere('q.description  LIKE :description')
                ->setParameter('description', '%' .  $filter['description'] . '%' );
        }

        if (isset($filter['category']) ?? null) {
            $qb->orWhere('c.title  LIKE :category')
                ->setParameter('category', '%' . $filter['category'] . '%');
        }

        if (isset($filter['author']) ?? null) {
            $qb->orWhere('a.firstName  LIKE :author')
                ->orWhere('a.lastName  LIKE :author')
                ->setParameter('author', '%' . $filter['author'] . '%');
        }
        return $paginator->paginate($qb->getQuery(), $page);
    }
}
