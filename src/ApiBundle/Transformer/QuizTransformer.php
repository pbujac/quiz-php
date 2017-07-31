<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\QuizDTO;
use AppBundle\Entity\Category;
use AppBundle\Entity\Quiz;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class QuizTransformer
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var QuestionTransformer */
    private $transformQuestion;

    /** @var UserTransformer */
    private $userTransformer;

    /** @var CategoryTransformer */
    private $categoryTransformer;

    /**
     * @param EntityManagerInterface $em
     * @param QuestionTransformer $transformQuestion
     * @param UserTransformer $userTransformer
     * @param CategoryTransformer $categoryTransformer
     */
    public function __construct(
        EntityManagerInterface $em,
        QuestionTransformer $transformQuestion,
        UserTransformer $userTransformer,
        CategoryTransformer $categoryTransformer
    ) {
        $this->em = $em;
        $this->transformQuestion = $transformQuestion;
        $this->userTransformer = $userTransformer;
        $this->categoryTransformer = $categoryTransformer;
    }


    /**
     * @param QuizDTO $quizDTO
     *
     * @param User $user
     * @return Quiz
     */
    public function transform(QuizDTO $quizDTO, User $user)
    {
        $quiz = new Quiz();
        $quiz->setTitle($quizDTO->title);
        $quiz->setDescription($quizDTO->description);
        $quiz->setAuthor($user);

        $category = $this->findCategoryById($quizDTO->category->id);
        $quiz->setCategory($category);

        foreach ($quizDTO->questions as $questionDTO) {
            $quiz->addQuestion(
                $this->transformQuestion->transformQuestionDTO($questionDTO, $quiz));
        }

        return $quiz;
    }

    /**
     * @param Quiz $quiz
     *
     * @return QuizDTO
     */
    public function reverseTransform(Quiz $quiz)
    {
        $quizDTO = new QuizDTO();

        $quizDTO->id = $quiz->getId();
        $quizDTO->title = $quiz->getTitle();
        $quizDTO->description = $quiz->getDescription();
        $quizDTO->createdAt = $quiz->getCreatedAt()->getTimestamp();
        $quizDTO->category = $this->categoryTransformer->reverseTransform(
            $quiz->getCategory()
        );
        $quizDTO->description = $quiz->getDescription();
        $quizDTO->author = $this->userTransformer->reverseTransform(
            $quiz->getAuthor()
        );
        $quizDTO->author = $this->userTransformer->reverseTransform(
            $quiz->getAuthor()
        );
        $quizDTO->questions = new ArrayCollection();

        foreach ($quiz->getQuestions() as $question) {
            $quizDTO->questions->add(
                $this->transformQuestion->reverseTransform($question)
            );
        }

        return $quizDTO;
    }

    /**
     * @param int $categoryId
     * @return Category|null|object
     */
    public function findCategoryById(int $categoryId)
    {
        $category = $this->em->getRepository(Category::class)
            ->findOneBy([
                "id" => $categoryId
            ]);
        return $category;
    }
}
