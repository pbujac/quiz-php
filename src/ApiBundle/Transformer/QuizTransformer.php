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
    public function transform(Quiz $quiz)
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
     * @return Quiz
     */
    public function reverseTransform(QuizDTO $quizDTO)
    {
        $quiz = new Quiz();
        $quiz->setTitle($quizDTO->title);
        $quiz->setDescription($quizDTO->description);
        $quiz->setCreatedAt();

        $quiz->setCategory(
            $this->em->getRepository(Category::class)->findOneBy([
                "id" => $quizDTO->categoryId
            ]));

        $quiz->setAuthor(
            $this->em->getRepository(User::class)->findOneBy([
                "id" => $quizDTO->authorId
            ]));

        foreach ($quizDTO->questions as $questionDTO) {
            $quiz->addQuestion(
                $this->transformQuestion->reverseTransform($questionDTO, $quiz));
        }

        return $quiz;
    }
}
