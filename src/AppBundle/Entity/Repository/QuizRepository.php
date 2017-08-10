<?php

namespace AppBundle\Entity\Repository;

use AdminBundle\Manager\PaginatorManager;
use AppBundle\Entity\User;
use AppBundle\Entity\Category;
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
     * @param array $filter
     * @param int $page
     * @param $count
     *
     * @return Paginator
     */
    public function getQuizByQueryAndPage(array $filter, int $page = 1, int $count)
    {
        $paginator = new PaginatorManager();

        $qb = $this->createQueryBuilder('q')
            ->addSelect('c, a')
            ->join('q.category', 'c')
            ->join('q.author', 'a');

        if ($filter['title'] ?? null) {
            $qb->orWhere('q.title LIKE :title')
                ->setParameter('title', '%' . $filter['title'] . '%');
        }

        if ($filter['description'] ?? null) {
            $qb->orWhere('q.description  LIKE :description')
                ->setParameter('description', '%' . $filter['description'] . '%');
        }

        if ($filter['category'] ?? null) {
            $qb->orWhere('c.title  LIKE :category')
                ->setParameter('category', '%' . $filter['category'] . '%');
        }

        if ($filter['author'] ?? null) {
            $qb->orWhere('a.firstName  LIKE :author')
                ->orWhere('a.lastName  LIKE :author')
                ->setParameter('author', '%' . $filter['author'] . '%');
        }
        return $paginator->paginate($qb->getQuery(), $page, $count);
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
            ->where('quiz.author = :user')
            ->setParameter('user', $user)
            ->getQuery();

        return $paginator->paginate($query, $page, $count);
    }

    /**
     * @param Category $category
     * @param int $page
     * @param int $count
     *
     * @return Paginator
     */
    public function getQuizzesByCategoryAndPage(Category $category, int $page, int $count)
    {
        $paginator = new PaginatorManager();

        $query = $this->createQueryBuilder('quiz')
            ->where('quiz.category = :category')
            ->setParameter('category', $category)
            ->getQuery();

        return $paginator->paginate($query, $page, $count);
    }
}
