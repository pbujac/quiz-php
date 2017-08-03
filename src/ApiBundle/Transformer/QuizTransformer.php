<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\QuizDTO;
use AppBundle\Entity\Category;
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

    /**
     * @param EntityManagerInterface $em
     * @param QuestionTransformer $transformQuestion
     */
    public function __construct(EntityManagerInterface $em, QuestionTransformer $transformQuestion)
    {
        $this->em = $em;
        $this->transformQuestion = $transformQuestion;
    }

    /**
     * @param Quiz $quiz
     *
     * @return QuizDTO
     */
    public function transform($quiz): QuizDTO
    {
        $quizDTO = new QuizDTO();
        $quizDTO->title = $quiz->getTitle();
        $quizDTO->description = $quiz->getDescription();
        $quizDTO->categoryId = $quiz->getCategory()->getId();
        $quizDTO->authorId = $quiz->getAuthor()->getId();

        $quizDTO->questions = new ArrayCollection();
        foreach ($quiz->getQuestions() as $question) {
            $quizDTO->questions->add($this->transformQuestion->transform($question));
        }

        return $quizDTO;
    }

    /**
     * @param QuizDTO $quizDTO
     *
     * @param Quiz|null $quiz
     * @return Quiz
     */
    public function reverseTransform($quizDTO, $quiz = null): Quiz
    {
        $quiz = $quiz ?: new Quiz();
        !$quizDTO->title ?: $quiz->setTitle($quizDTO->title);
        !$quizDTO->description ?: $quiz->setDescription($quizDTO->description);
        $quiz->setCreatedAt();

        !$quizDTO->categoryId ?: $quiz->setCategory(
            $this->em->getRepository(Category::class)->findOneBy([
                "id" => $quizDTO->categoryId
            ]));

        !$quizDTO->authorId ?: $quiz->setAuthor(
            $this->em->getRepository(User::class)->findOneBy([
                "id" => $quizDTO->authorId
            ]));

        foreach ($quizDTO->questions as $questionDTO) {
            !$quizDTO->questions ?: $quiz->addQuestion(
                $this->transformQuestion->reverseTransform($questionDTO));
        }

        return $quiz;
    }

    public function getEntityClass(): string
    {
        return Quiz::class;
    }

}
