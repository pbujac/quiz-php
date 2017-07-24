<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Repository\CategoryRepository;
use ApiBundle\DTO\CategoryDTO;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;


class CategoryController
{
    /**
     * Gets a collection of BlogPosts
     *
     * @return array
     *
     * @ApiDoc(
     *     output="AppBundle\Entity\BlogPost",
     *     statusCodes={
     *         200 = "Returned when successful",
     *         404 = "Return when not found"
     *     }
     * )
     */
    public function cgetAction()
    {
    }


}
