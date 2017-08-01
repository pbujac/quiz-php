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

    public function getQuizByQueryAndPage(?string $filter = null, int $page = 1)
    {
        $paginator = new PaginatorManager();

        $qb = $this->createQueryBuilder('q')
            ->addSelect('c, a')
            ->join('q.category', 'c')
            ->join('q.author', 'a');

        $parsed[] = ($title = null . $description = null . $category = null . $author = null);

        if (parse_str($filter, $parsed)) {
            $qb->where('q.title LIKE :title')
                ->orWhere('q.description  LIKE :description')
                ->orWhere('q.category  LIKE :category')
                ->orWhere('q.author  LIKE :author')
                ->setParameter('title', '%' . $parsed.$title . '%')
                ->setParameter('description', '%' . $parsed.$description . '%')
                ->setParameter('category', '%' . $parsed.$category . '%')
                ->setParameter('author', '%' . $parsed.$author . '%');
        }

        return $paginator->paginate($qb->getQuery(), $page);


    }

}
