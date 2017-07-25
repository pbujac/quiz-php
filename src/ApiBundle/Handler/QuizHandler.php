<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuizDTO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class QuizHandler
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @param EntityManagerInterface $em */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param QuizDTO $quizDTO
     */
    public function quizHandler(QuizDTO $quizDTO)
    {
        $quizDTO->addQuiz();
    }
}
