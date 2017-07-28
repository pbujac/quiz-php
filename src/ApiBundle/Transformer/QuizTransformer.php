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
    public function transformQuizDTO(QuizDTO $quizDTO)
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
                $this->transformQuestion->transformQuestionDTO($questionDTO, $quiz));
        }

        return $quiz;
    }

    /**
     * @param Quiz $quiz
     *
     * @return QuizDTO
     */
    public function transformQuizObj(Quiz $quiz){
        $quizDTO = new QuizDTO();
        $quizDTO->title=$quiz->getTitle();
        $quizDTO->description=$quiz->getDescription();
        $quizDTO->category_id=$quiz->getCategory()->getId();
        $quizDTO->author_id=$quiz->getAuthor()->getId();

        foreach ($quiz->getQuestions() as $question){
            $this->transformQuestion->transformQuestionObj($question);
        }
        return $quizDTO;
    }
}
