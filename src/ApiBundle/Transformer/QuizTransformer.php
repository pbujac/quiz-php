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

    /**
     * QuizTransformer constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param QuizDTO $quizDTO
     *
     * @return Quiz
     */
    public function transformQuizDTO(QuizDTO $quizDTO)
    {
        $quiz = new Quiz();
        $quiz->setTitle($quizDTO->getTitle());
        $quiz->setCategory($this->em->getRepository(Category::class)->findOneBy(["id" => $quizDTO->getCategoryId()]));
        $quiz->setDescription($quizDTO->getDescription());
        $quiz->setCreatedAt();
        $quiz->setAuthor($this->em->getRepository(User::class)->findOneBy(["id" => $quizDTO->getAuthorId()]));

        $question = new QuestionTransformer();
        foreach ($quizDTO->getQuestions() as $questionDTO) {
            $quiz->addQuestion($question->transformQuestionDTO($questionDTO));
        }

        return $quiz;
    }
}
