<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\DTO\ResultDTO;
use ApiBundle\Manager\ApiPaginatorManager;
use ApiBundle\Traits\ValidationErrorTrait;
use ApiBundle\Transformer\QuizTransformer;
use ApiBundle\Transformer\ResultTransformer;
use AppBundle\Entity\Category;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;
use AppBundle\Entity\Result;
use AppBundle\Entity\ResultAnswer;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
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
     * @param QuizDTO $quizDTO
     * @param Quiz $quiz
     *
     * @return QuizDTO
     */
    public function handlePatch(QuizDTO $quizDTO, Quiz $quiz)
    {
        $this->quizTransformer->reverseTransform($quizDTO, $quiz);
        $this->em->flush();

        return $quizDTO;
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

        $quizzesDTO = $this->addQuizzesDTO($quizzes['paginator']);

        $quizzesPagination = $this->getQuizzesPagination($quizzesDTO);

        return ApiPaginatorManager::paginate(
            $quizzesPagination,
            $page,
            'api.user.quizzes',
            $quizzes['totalItems'],
            $count
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

        $quizzesDTO = $this->addQuizzesDTO($quizzes['paginator']);

        $quizzesPagination = $this->getQuizzesPagination($quizzesDTO);

        return ApiPaginatorManager::paginate(
            $quizzesPagination,
            $page,
            'api.category.quizzes',
            $quizzes['totalItems'],
            $count,
            ['category_id' => $category->getId()]
        );
    }

    /**
     * @param ResultDTO $resultDTO
     * @param Quiz $quiz
     * @param User $user
     *
     * @return ResultDTO
     */
    public function handleSolveQuiz(ResultDTO $resultDTO, Quiz $quiz, User $user): ResultDTO
    {
        $this->validateResultDTO($resultDTO);
//        $this->checkExistResult($quiz);
        $result = new Result();
        $result->setQuiz($quiz);
        $result->setUser($user);
        $result = $this->resultTransformer->reverseTransform($resultDTO, $result);

        $score = $this->calculateScore($quiz->getQuestions(), $result->getResultAnswers());
        $result->setScore($score);

        $this->em->persist($result);
        $this->em->flush();

        return $this->resultTransformer->transform($result);
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

        $quizzesDTO = $this->addQuizzesDTO($quizzes['paginator']);
        $quizzesPagination = $this->getQuizzesPagination($quizzesDTO);

        return ApiPaginatorManager::paginate(
            $quizzesPagination,
            $page,
            'api.quizzes.list',
            $quizzes['totalItems'],
            $count
        );
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
     * @param PersistentCollection|Question[] $questions
     * @param ArrayCollection|ResultAnswer[] $resultAnswers
     *
     * @return int
     */
    private function calculateScore(PersistentCollection $questions, ArrayCollection $resultAnswers): int
    {
        $scorePoints = 0;

        foreach ($questions as $question) {

            $correctAnswers = $this->getCorrectAnswers($question);
            $choseAnswers = $this->getChoseAnswers($resultAnswers, $question);
            $scorePoints += $this->calculateQuestionScorePoints($question, $choseAnswers, $correctAnswers);
        }

        $finalScore = ceil($scorePoints * 100) / $questions->count();

        return $finalScore;
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
     * @param Question $question
     *
     * @return array
     */
    private function getCorrectAnswers(Question $question): array
    {
        $correctAnswers = [];

        foreach ($question->getAnswers() as $answer) {

            if ($answer->isCorrect()) {
                $correctAnswers[] = $answer->getId();
            }
        }

        return $correctAnswers;
    }

    /**
     * @param ArrayCollection $resultAnswers
     * @param Question $question
     *
     * @return array
     */
    private function getChoseAnswers(ArrayCollection $resultAnswers, Question $question): array
    {
        $choseAnswers = [];

        foreach ($resultAnswers as $resultAnswer) {

            if ($resultAnswer->getAnswer()->getQuestion()->getId() === $question->getId()) {
                $choseAnswers[] = $resultAnswer->getAnswer()->getId();
            }
        }

        return $choseAnswers;
    }


    /**
     * @param Question $question
     * @param array $choseAnswers
     * @param array $correctAnswers
     *
     * @return float|int
     */
    private function calculateQuestionScorePoints(Question $question, array $choseAnswers, array $correctAnswers)
    {
        $questionScorePoints = 0;
        $finalScore = 0;

        if (count($choseAnswers) > 0) {

            $questionScorePoints = $this->getQuestionScorePoints($question, $correctAnswers, $choseAnswers, $questionScorePoints);

            $finalScore += $questionScorePoints / $question->getAnswers()->count();
        }

        return $finalScore;
    }


    /**
     * @param Question $question
     * @param array $correctAnswers
     * @param array $choseAnswers
     * @param int $questionScorePoints
     *
     * @return int
     */
    private function getQuestionScorePoints(
        Question $question,
        array $correctAnswers,
        array $choseAnswers,
        int $questionScorePoints
    ): int {
        foreach ($question->getAnswers() as $answer) {

            if (
                in_array($answer->getId(), $correctAnswers) && in_array($answer->getId(), $choseAnswers)
                ||
                !in_array($answer->getId(), $correctAnswers) && !in_array($answer->getId(), $choseAnswers)
            ) {
                ++$questionScorePoints;
            }
        }

        return $questionScorePoints;
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
     * @param Quiz $quiz
     */
    private function checkExistResult(Quiz $quiz): void
    {
        $result = $this->em->getRepository(Result::class)->findBy([
            'quiz' => $quiz,
        ]);

        if ($result) {
            $error = new ConstraintViolation(
                'Result on this quiz already exist',
                '', [],
                null,
                'quiz',
                'id'
            );
            $errors = new ConstraintViolationList();
            $errors->add($error);

            $errorMessage = $this->getErrorMessage($errors);

            throw new BadRequestHttpException($errorMessage);
        }
    }

}
