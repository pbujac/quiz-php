<?php

namespace ApiBundle\Controller;

use ApiBundle\Handler\QuizHandler;
use ApiBundle\Transformer\QuizDTOTransformer;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class QuizByIdController extends FOSRestController
{
    /**
     * @Rest\Get("/quiz/{quiz_id}", name="quiz")
     *
     * @param int $quiz_id
     *
     * @return Response
     */
    public function getAction(int $quiz_id)
    {
        $this->get(QuizHandler::class)->getByIdAction($quiz_id);

        return new Response('Hello. this is quiz id = ' .$quiz_id);
    }
}
