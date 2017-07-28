<?php

namespace ApiBundle\Controller;

use ApiBundle\CategoryHandler;
use ApiBundle\DTO\CategoryDTO;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

/**
 * Class CategoryController
 *
 * @Rest\Route("/categories")
 */
class CategoryController extends FOSRestController
{
  // /**
    // * @Rest\Get("")
     //*
     //* @return View
     //*/
    //public function getAction()
    //{
      //  $this->get(CategoryHandler::class)->getList();

    //    return new View('', Response::HTTP_OK);
  //  }



}
