<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\Transformer\QuizTransformer;
use AppBundle\Entity\Quiz;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
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
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param QuizTransformer $transformQuiz
     */
    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        QuizTransformer $transformQuiz
    ) {
        $this->em = $em;
        $this->validator = $validator;
        $this->transformQuiz = $transformQuiz;
    }

    /**
     * @param QuizDTO $quizDTO
     */
    public function postAction(QuizDTO $quizDTO)
    {
        $this->validateQuizDTO($quizDTO);
        $this->em->persist($this->transformQuiz->transformQuizDTO($quizDTO));
        $this->em->flush();
    }


    /**
     * @param User $user
     * @param int $page
     * @param int $count
     *
     * @return PaginatedRepresentation
     */
    public function getQuizzesByUser(User $user, int $page, int $count)
    {
        $quizzes = $this->em
            ->getRepository(Quiz::class)
            ->getQuizzesByAuthorAndPage($user, $page, $count);

        $quizzesDTO = new ArrayCollection();
        $this->addQuizzesToDTO($quizzes, $quizzesDTO);

        return $this->paginate($quizzesDTO);
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

    /**
     * @param Paginator|Quiz[] $quizzes
     * @param ArrayCollection|Quiz[] $quizzesDTO
     */
    public function addQuizzesToDTO(
        Paginator $quizzes,
        ArrayCollection $quizzesDTO
    ) {
        foreach ($quizzes as $quiz) {
            $quizzesDTO->add(
                $this->transformQuiz->reverseTransform($quiz)
            );
        }
    }

    /**
     * @param ArrayCollection|Quiz[] $quizzes
     *
     * @return PaginatedRepresentation
     */
    private function paginate(ArrayCollection $quizzes)
    {
        $totalQuizzes = $quizzes->count();

        $collectionRepresentation = new CollectionRepresentation(
            $quizzes,
            'quizzes'
        );

        return new PaginatedRepresentation(
            $collectionRepresentation,
            'api.user.quizzes',
            [],
            null,
            null,
            null,
            'page',
            'count',
            false,
            $totalQuizzes
        );
    }
}
