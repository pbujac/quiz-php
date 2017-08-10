<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\DTO\ResultDTO;
use ApiBundle\Manager\ApiPaginatorManager;
use ApiBundle\Traits\ValidationErrorTrait;
use ApiBundle\Transformer\QuizTransformer;
use ApiBundle\Transformer\ResultTransformer;
use AppBundle\Entity\Category;
use AppBundle\Entity\Quiz;
use AppBundle\Entity\Result;
use AppBundle\Entity\ResultAnswer;
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
    private $quizTransformer;

    /** @var ResultTransformer */
    private $resultTransformer;

    /**
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param QuizTransformer $quizTransformer
     * @param ResultTransformer $resultTransformer
     */
    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        QuizTransformer $quizTransformer,
        ResultTransformer $resultTransformer
    ) {
        $this->em = $em;
        $this->validator = $validator;
        $this->quizTransformer = $quizTransformer;
        $this->resultTransformer = $resultTransformer;
    }

    /**
     * @param Quiz $quiz
     *
     * @return QuizDTO
     */
    public function handleGetQuiz(Quiz $quiz)
    {
        return $this->quizTransformer->transform($quiz);
    }

    /**
     * @param int $page
     * @param int $count
     * @param array $filter
     *
     * @return PaginatedRepresentation
     */
    public function searchByFilter(int $page, int $count, array $filter)
    {
        $quizzes = $this->em->getRepository(Quiz::class)
            ->getQuizByQueryAndPage($filter, $page, $count);

        $quizzesDTO = $this->addQuizzesDTO($quizzes);
        $quizzesPagination = $this->getQuizzesPagination($quizzesDTO);

        return ApiPaginatorManager::paginate(
            $quizzesPagination,
            $page,
            'api.quizzes.list'
        );
    }


    /**
     * @param QuizDTO $quizDTO
     * @param User $user
     */
    public function handlePostQuiz(QuizDTO $quizDTO, User $user): void
    {
        $this->validateQuizDTO($quizDTO);

        $quiz = new Quiz();
        $quiz->setAuthor($user);
        $quiz = $this->quizTransformer->reverseTransform($quizDTO, $quiz);

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
    public function handleGetQuizzesByUser(User $user, int $page, int $count): PaginatedRepresentation
    {
        $quizzes = $this->em->getRepository(Quiz::class)
            ->getQuizzesByAuthorAndPage($user, $page, $count);

        $quizzesDTO = $this->addQuizzesDTO($quizzes);

        $quizzesPagination = $this->getQuizzesPagination($quizzesDTO);

        return ApiPaginatorManager::paginate(
            $quizzesPagination,
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
    public function handleGetQuizzesByCategory(Category $category, int $page, int $count)
    {
        $quizzes = $this->em->getRepository(Quiz::class)
            ->getQuizzesByCategoryAndPage($category, $page, $count);

        $quizzesDTO = $this->addQuizzesDTO($quizzes);

        $quizzesPagination = $this->getQuizzesPagination($quizzesDTO);

        return ApiPaginatorManager::paginate(
            $quizzesPagination,
            $page,
            'api.category.quizzes',
            ['category_id' => $category->getId()]
        );
    }

    /**
     * @param ResultDTO $resultDTO
     * @param Quiz $quiz
     * @param User $user
     */
    public function handleSolveQuiz(ResultDTO $resultDTO, Quiz $quiz, User $user): void
    {
        $this->validateResultDTO($resultDTO);

        $result = new Result();
        $result->setQuiz($quiz);
        $result->setUser($user);

        $result = $this->resultTransformer->reverseTransform($resultDTO, $result);

        $score = $this->calculateScore($result->getResultAnswers());
        $result->setScore($score);

        $this->em->persist($result);
        $this->em->flush();
    }

    /**
     * @param Paginator $quizzes
     *
     * @return ArrayCollection
     */
    private function addQuizzesDTO(Paginator $quizzes): ArrayCollection
    {
        $quizzesDTO = new ArrayCollection();

        foreach ($quizzes as $quiz) {
            $quizDTO = $this->quizTransformer->transform($quiz);

            $quizzesDTO->add($quizDTO);
        }

        return $quizzesDTO;
    }

    /**
     * @param ArrayCollection|ResultAnswer[] $resultAnswers
     *
     * @return int
     */
    private function calculateScore(ArrayCollection $resultAnswers): int
    {
        $correctAnswers = 0;

        foreach ($resultAnswers as $resultAnswer) {

            if ($resultAnswer->getAnswer()->isCorrect()) {
                ++$correctAnswers;
            }
        }

        return ceil(($correctAnswers / $resultAnswers->count()) * 100);
    }

    /**
     * @param ArrayCollection $quizzesDTO
     *
     * @return CollectionRepresentation
     */
    private function getQuizzesPagination(ArrayCollection $quizzesDTO): CollectionRepresentation
    {
        return new CollectionRepresentation($quizzesDTO, 'quizzes');
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
     * @param ResultDTO $resultDTO
     */
    private function validateResultDTO(ResultDTO $resultDTO): void
    {
        $errors = $this->validator->validate($resultDTO, null, ['quiz_solve']);

        if (count($errors) > 0) {
            $errorMessage = $this->getErrorMessage($errors);

            throw new BadRequestHttpException($errorMessage);
        }
    }

}
