<?php

namespace AppBundle\Entity\Repository;

use AdminBundle\Manager\PaginatorManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use FOS\RestBundle\Request\ParamFetcher;

//use FOS\RestBundle\Controller\Annotations\FileParam;

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
     * @param ParamFetcher $paramFetcher
     * @param int $page
     *
     * @return Paginator
     */
    public function getQuizByQueryAndPage(ParamFetcher $paramFetcher, int $page = 1)
    {
        $paginator = new PaginatorManager();

        $qb = $this->createQueryBuilder('q')
            ->addSelect('c, a')
            ->join('q.category', 'c')
            ->join('q.author', 'a');

        $title = $paramFetcher->get('title');
        $description = $paramFetcher->get('description');
        $category = $paramFetcher->get('category');
        $author = $paramFetcher->get('author');

        if ($title) {
            $qb->orWhere('q.title LIKE :title')
                ->setParameter('title', '%' . $paramFetcher->get('title') . '%');
        }

        if ($description) {
            $qb->orWhere('q.description  LIKE :description')
                ->setParameter('description', '%' . $paramFetcher->get('description') . '%');
        }

        if ($category) {
            $qb->orWhere('q.category  LIKE :category')
                ->setParameter('category', '%' . $paramFetcher->get('category') . '%');
        }

        if ($author) {
            $qb->orWhere('q.author  LIKE :author')
                ->setParameter('author', '%' . $paramFetcher->get('author') . '%');
        }

        return $paginator->paginate($qb->getQuery(), $page);
    }
}
