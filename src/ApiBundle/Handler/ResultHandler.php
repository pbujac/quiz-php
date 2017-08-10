<?php

namespace ApiBundle\Handler;

use ApiBundle\Manager\ApiPaginatorManager;
use ApiBundle\Traits\ValidationErrorTrait;
use ApiBundle\Transformer\ResultTransformer;
use AppBundle\Entity\Result;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;

class ResultHandler
{
    use ValidationErrorTrait;

    /** @var EntityManagerInterface $em */
    private $em;

    /** @var ResultTransformer */
    private $resultTransformer;

    /**
     * @param EntityManagerInterface $em
     * @param ResultTransformer $resultTransformer
     */
    public function __construct(
        EntityManagerInterface $em,
        ResultTransformer $resultTransformer
    ) {
        $this->em = $em;
        $this->resultTransformer = $resultTransformer;
    }

    /**
     * @param User $user
     * @param int $page
     * @param int $count
     *
     * @return PaginatedRepresentation
     */
    public function handleGetResultsByUser(User $user, int $page, int $count): PaginatedRepresentation
    {
        $quizzes = $this->em->getRepository(Result::class)
            ->getResultsByUserAndPage($user, $page, $count);

        $quizzesDTO = $this->addResultsDTO($quizzes['paginator']);

        $quizzesPagination = $this->getResultsPagination($quizzesDTO);

        return ApiPaginatorManager::paginate(
            $quizzesPagination,
            $page,
            'api.user.results',
            $quizzes['totalItems'],
            $count
        );
    }

    /**
     * @param Paginator $results
     *
     * @return ArrayCollection
     */
    private function addResultsDTO(Paginator $results): ArrayCollection
    {
        $resultsDTO = new ArrayCollection();

        foreach ($results as $result) {
            $resultDTO = $this->resultTransformer->transform($result);

            $resultsDTO->add($resultDTO);
        }

        return $resultsDTO;
    }

    /**
     * @param ArrayCollection $quizzesDTO
     *
     * @return CollectionRepresentation
     */
    private function getResultsPagination(ArrayCollection $quizzesDTO): CollectionRepresentation
    {
        return new CollectionRepresentation($quizzesDTO, 'results');
    }

}
