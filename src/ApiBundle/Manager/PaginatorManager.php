<?php

namespace ApiBundle\Manager;

use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;

class PaginatorManager
{
    /**
     * @param CollectionRepresentation $collectionRepresentation
     * @param string $route
     * @param array $routeParams
     * @param int $page
     *
     * @return PaginatedRepresentation
     */
    public function paginate(
        CollectionRepresentation $collectionRepresentation,
        int $page,
        string $route,
        array $routeParams = []
    ) {

        return new PaginatedRepresentation(
            $collectionRepresentation,
            $route,
            $routeParams,
            $page,
            null,
            null,
            'page',
            'count',
            false,
            null
        );
    }
}
