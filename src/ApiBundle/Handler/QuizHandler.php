<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\Transformer\QuizTransformer;
use AppBundle\Entity\Quiz;
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
    private $quizTransformer;

    /**
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param QuizTransformer $quizTransformer
     */
    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        QuizTransformer $quizTransformer
    )
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->quizTransformer = $quizTransformer;
    }

    /**
     * @param QuizDTO $quizDTO
     */
    public function handleCreate(QuizDTO $quizDTO)
    {
        $this->validateQuizDTO($quizDTO);
        $this->em->persist($this->quizTransformer->reverseTransform($quizDTO));
        $this->em->flush();
    }

    /**
     * @param int $quizId
     *
     * @return QuizDTO
     */
    public function handleGetQuiz(int $quizId)
    {
        $quiz = $this->em->getRepository(Quiz::class)->findOneBy(["id" => $quizId]);

        if ($quiz != null){
            return $this->quizTransformer->transform($quiz);
        }
        else throw new BadRequestHttpException("Quiz with this id does not exist");
    }

    /**
     * @param QuizDTO $quizDTO
     * @param Quiz $quiz
     *
     * @return QuizDTO
     */
    public function handlePatch(QuizDTO $quizDTO, Quiz $quiz)
    {
        $this->validateQuizDTO($quizDTO);
        $this->em->persist($this->quizTransformer->reverseTransform($quizDTO, $quiz));
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
