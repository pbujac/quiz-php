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
                "id" => $quizDTO->categoryId
            ]));

        $quiz->setAuthor(
            $this->em->getRepository(User::class)->findOneBy([
                "id" => $quizDTO->authorId
            ]));

        foreach ($quizDTO->questions as $questionDTO) {
            $quiz->addQuestion(
                $this->transformQuestion->transform($questionDTO, $quiz));
        }

        return $quiz;
    }
}
