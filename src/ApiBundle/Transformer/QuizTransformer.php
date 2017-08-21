<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\QuizDTO;
use AppBundle\Entity\Category;
use AppBundle\Entity\Question;
use AppBundle\Entity\Quiz;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class QuizTransformer implements TransformerInterface
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
    public function transform($quiz): QuizDTO
    {
        $quizDTO = new QuizDTO();

        $quizDTO->id = $quiz->getId();
        $quizDTO->title = $quiz->getTitle();
        $quizDTO->description = $quiz->getDescription();
        $quizDTO->createdAt = $quiz->getCreatedAt()->getTimestamp();
        $quizDTO->description = $quiz->getDescription();
        $quizDTO->category = $this->categoryTransformer->transform($quiz->getCategory());
        $quizDTO->author = $this->userTransformer->transform($quiz->getAuthor());
        $this->addQuestionsDTO($quiz, $quizDTO);

        return $quizDTO;
    }

    /**
     * @param QuizDTO $quizDTO
     * @param Quiz|null $quiz
     *
     * @return Quiz
     */
    public function reverseTransform($quizDTO, $quiz = null): Quiz
    {
        $quiz = $quiz ?: new Quiz();
        !$quizDTO->title ?: $quiz->setTitle($quizDTO->title);
        !$quizDTO->description ?: $quiz->setDescription($quizDTO->description);
        !$quizDTO->category ?: $this->setQuizCategory($quiz, $quizDTO->category->id);
        !$quizDTO->author?: $this->setQuizAuthor($quiz, $quizDTO->author->id);
        $this->addQuestions($quizDTO, $quiz);

        return $quiz;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return Quiz::class;
    }

    /**
     * @param Quiz $quiz
     * @param int $categoryId
     */
    private function setQuizCategory(Quiz $quiz, int $categoryId): void
    {
        $category = $this->em->getRepository(Category::class)
            ->findOneBy(["id" => $categoryId]);

        $quiz->setCategory($category);
    }

    /**
     * @param Quiz $quiz
     * @param int $authorId
     */
    private function setQuizAuthor(Quiz $quiz, int $authorId): void
    {
        $author = $this->em->getRepository(User::class)
            ->findOneBy(["id" => $authorId]);

        $quiz->setAuthor($author);
    }

    /**
     * @param QuizDTO $quizDTO
     * @param Quiz $quiz
     */
    private function addQuestions(QuizDTO $quizDTO, Quiz $quiz): void
    {
        if ($quizDTO->questions) {

            foreach ($quizDTO->questions as $questionDTO) {
                $question = new Question();
                $question->setQuiz($quiz);
                $question = $this->transformQuestion->reverseTransform($questionDTO, $question);

                $quiz->addQuestion($question);
            }
        }
    }

    /**
     * @param Quiz $quiz
     * @param QuizDTO $quizDTO
     */
    public function addQuestionsDTO(Quiz $quiz, QuizDTO $quizDTO): void
    {
        $quizDTO->questions = new ArrayCollection();

        foreach ($quiz->getQuestions() as $question) {
            $questionDTO = $this->transformQuestion->transform($question);

            $quizDTO->questions->add($questionDTO);
        }
    }

}
