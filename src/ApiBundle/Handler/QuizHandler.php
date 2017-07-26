<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\Transformer\QuizTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuizHandler
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * QuizHandler constructor.
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    /**
     * @param QuizDTO $quizDTO
     */
    public function quizHandler(QuizDTO $quizDTO)
    {
//        $questionHandler = new QuizHandler();

        $quizTransformer = new QuizTransformer();
        $quizTransformer->transformQuizDTO($quizDTO);
    }
}
