<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\QuizDTO;
use AppBundle\Entity\Category;
use AppBundle\Entity\Quiz;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class QuizTransformer
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var QuestionTransformer */
    private $questionTransformer;

    /**
     * @param EntityManagerInterface $em
     * @param QuestionTransformer $questionTransform
     */
    public function __construct(EntityManagerInterface $em, QuestionTransformer $questionTransform)
    {
        $this->em = $em;
        $this->questionTransformer = $questionTransform;
    }

    /**
     * @param QuizDTO $quizDTO
     *
     * @return Quiz
     */
    public function transform(QuizDTO $quizDTO)
    {
        $quiz = new Quiz();
        $quiz->setTitle($quizDTO->title);
        $quiz->setDescription($quizDTO->description);
        $quiz->setCreatedAt();

        $quiz->setCategory(
            $this->em->getRepository(Category::class)->findOneBy([
                "id" => $quizDTO->category_id
            ]));

        $quiz->setAuthor(
            $this->em->getRepository(User::class)->findOneBy([
                "id" => $quizDTO->author_id
            ]));

        foreach ($quizDTO->questions as $questionDTO) {
            $quiz->addQuestion(
                $this->questionTransformer->transformQuestion($questionDTO, $quiz));
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
        $quizDTO->title = $quiz->getTitle();
        $quizDTO->description = $quiz->getDescription();
        $quizDTO->categoryId= $quiz->getCategory()->getId();
        $quizDTO->authorId= $quiz->getAuthor()->getId();

        return $quizDTO;
    }
}
