<?php

namespace ApiBundle\Handler;

use Doctrine\ORM\EntityManagerInterface;

class QuizSearchHandler
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    public function handleQuizSearch()
    {


    }


}
