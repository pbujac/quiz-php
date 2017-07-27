<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\Transformer\QuizTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuizHandler
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var ValidatorInterface */
    private $validator;

    /** @var QuizTransformer */
    private $transformQuiz;

    /**
     * QuizHandler constructor.
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param QuizTransformer $transformQuiz
     */
    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator, QuizTransformer $transformQuiz)
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->transformQuiz = $transformQuiz;
    }

    /**
     * @param QuizDTO $quizDTO
     */
    public function insertQuiz(QuizDTO $quizDTO)
    {
//        $questionHandler = new QuizHandler();
//        $this->validateQuizDTO($quizDTO);



        $this->em->persist($this->transformQuiz->transformQuizDTO($quizDTO));
        $this->em->flush();
    }

    /**
     * @param QuizDTO $quizDTO
     */
    public function validateQuizDTO(QuizDTO $quizDTO): void
    {
        $errors = $this->validator->validate($quizDTO);

        if (count($errors) > 0) {
            $errorMessage = "";
            foreach ($errors as $violation) {
                $errorMessage .= $violation->getPropertyPath() . '-' . $violation->getMessage();
            }
            throw new BadRequestHttpException($errorMessage);
        }
    }
}
