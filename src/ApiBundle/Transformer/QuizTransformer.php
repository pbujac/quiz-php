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
     * @param Quiz $quiz
     *
     * @return QuizDTO
     */
    public function transform(Quiz $quiz)
    {
        $quizDTO = new QuizDTO();

        $quizDTO->id = $quiz->getId();
        $quizDTO->title = $quiz->getTitle();
        $quizDTO->description = $quiz->getDescription();
        $quizDTO->createdAt = $quiz->getCreatedAt()->getTimestamp();
        $quizDTO->description = $quiz->getDescription();
        $quizDTO->category = $this->categoryTransformer->transform(
            $quiz->getCategory()
        );
        $quizDTO->author = $this->userTransformer->transform(
            $quiz->getAuthor()
        );
        $quizDTO->author = $this->userTransformer->transform(
            $quiz->getAuthor()
        );
        $this->addQuestionsDTO($quiz, $quizDTO);

        return $quizDTO;
    }

    /**
     * @param QuizDTO $quizDTO
     * @param Quiz|null $quiz
     * @param User|null $user
     *
     * @return Quiz
     */
    public function reverseTransform(
        QuizDTO $quizDTO,
        User $user = null,
        Quiz $quiz = null
    ) {
        $quiz = $quiz ?: new Quiz();
        $quiz->setTitle($quizDTO->title);
        $quiz->setDescription($quizDTO->description);
        $quiz->setAuthor($user);
        $this->setQuizCategory(
            $quiz,
            $quizDTO->category->id
        );

        $this->addQuestions($quizDTO, $quiz);

        return $quiz;
    }

    /**
     * @param Quiz $quiz
     * @param int $categoryId
     */
    private function setQuizCategory(Quiz $quiz, int $categoryId)
    {
        $category = $this->em->getRepository(Category::class)
            ->findOneBy([
                "id" => $categoryId
            ]);

        $quiz->setCategory($category);
    }

    /**
     * @param QuizDTO $quizDTO
     * @param Quiz $quiz
     */
    private function addQuestions(QuizDTO $quizDTO, Quiz $quiz)
    {
        foreach ($quizDTO->questions as $questionDTO) {
            $quiz->addQuestion(
                $this->transformQuestion->reverseTransform(
                    $questionDTO,
                    $quiz
                )
            );
        }
    }

    /**
     * @param Quiz $quiz
     * @param $quizDTO
     */
    public function addQuestionsDTO(Quiz $quiz, $quizDTO)
    {
        $quizDTO->questions = new ArrayCollection();

        foreach ($quiz->getQuestions() as $question) {
            $quizDTO->questions->add(
                $this->transformQuestion->transform($question)
            );
        }
    }
}
