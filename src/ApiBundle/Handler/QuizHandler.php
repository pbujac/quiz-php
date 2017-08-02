<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\Manager\ApiPaginatorManager;
use ApiBundle\Traits\ValidationErrorTrait;
use ApiBundle\Transformer\QuizTransformer;
use AppBundle\Entity\Category;
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
    use ValidationErrorTrait;

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
     * @param User $user
     */
    public function postAction(QuizDTO $quizDTO, User $user)
    {
        $this->validateQuizDTO($quizDTO);

        $quiz = $this->transformQuiz->reverseTransform(
            $quizDTO,
            $user
        );

        $this->em->persist($quiz);
        $this->em->flush();
    }

    /**
     * @param User $user
     * @param int $page
     * @param int $count
     *
     * @return PaginatedRepresentation
     */
    public function handleGetQuizzesByUser(
        User $user,
        int $page,
        int $count
    ) {
        $quizzes = $this->em
            ->getRepository(Quiz::class)
            ->getQuizzesByAuthorAndPage($user, $page, $count);

        $quizzesDTO = $this->addQuizzesToDTO($quizzes);

        $paginator = new ApiPaginatorManager();

        $collectionRepresentation = $this->getQuizCollectionRepresentation(
            $quizzesDTO
        );

        return $paginator->paginate(
            $collectionRepresentation,
            $page,
            'api.user.quizzes'
        );
    }

    /**
     * @param Category $category
     * @param int $page
     * @param int $count
     *
     * @return PaginatedRepresentation
     */
    public function handleGetQuizzesByCategory(
        Category $category,
        int $page,
        int $count
    ) {
        $quizzes = $this->em
            ->getRepository(Quiz::class)
            ->getQuizzesByCategoryAndPage($category, $page, $count);

        $quizzesDTO = $this->addQuizzesToDTO($quizzes);

        $paginator = new ApiPaginatorManager();

        $collectionRepresentation = $this->getQuizCollectionRepresentation(
            $quizzesDTO
        );

        return $paginator->paginate(
            $collectionRepresentation,
            $page,
            'api.category.quizzes',
            ['category_id' => $category->getId()]
        );
    }

    /**
     * @param Paginator $quizzes
     *
     * @return ArrayCollection
     */
    private function addQuizzesToDTO(Paginator $quizzes): ArrayCollection
    {
        $quizzesDTO = new ArrayCollection();

        foreach ($quizzes as $quiz) {
            $quizzesDTO->add(
                $this->transformQuiz->transform($quiz)
            );
        }

        return $quizzesDTO;
    }

    /**
     * @param QuizDTO $quizDTO
     */
    private function validateQuizDTO(QuizDTO $quizDTO): void
    {
        $errors = $this->validator->validate($quizDTO);

        if (count($errors) > 0) {
            $errorMessage = $this->getErrorMessage($errors);

            throw new BadRequestHttpException($errorMessage);
        }
    }

    /**
     * @param ArrayCollection $quizzesDTO
     *
     * @return CollectionRepresentation
     */
    private function getQuizCollectionRepresentation(
        ArrayCollection $quizzesDTO
    ): CollectionRepresentation {
        $collectionRepresentation = new CollectionRepresentation(
            $quizzesDTO,
            'quizzes'
        );

        return $collectionRepresentation;
    }
}
