<?php

namespace ApiBundle\Manager;

use AdminBundle\Manager\PaginatorManager;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;

class ApiPaginatorManager
{
    /**
     * @param CollectionRepresentation $collectionRepresentation
     * @param int $page
     *
     * @param string $route
     * @param string $total
     * @param int $count
     * @param array $routeParams
     *
     * @return PaginatedRepresentation
     */
    public static function paginate(
        CollectionRepresentation $collectionRepresentation,
        int $page,
        string $route,
        string $total,
        int $count= PaginatorManager::PAGE_LIMIT,
        array $routeParams = []
    ) {

        return new PaginatedRepresentation(
            $collectionRepresentation,
            $route,
            $routeParams,
            $page,
            $count,
            null,
            'page',
            'count',
            false,
            $total
        );
    }
}
