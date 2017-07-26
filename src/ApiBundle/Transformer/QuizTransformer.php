<?php

namespace ApiBundle\Transformer;


use ApiBundle\DTO\QuizDTO;
use AppBundle\Entity\Quiz;

class QuizTransformer
{
    /**
     * @param QuizDTO $quizDTO
     *
     * @return Quiz
     */
    public function transformQuizDTO(QuizDTO $quizDTO){
        $quiz = new Quiz();
        $quiz->setTitle($quizDTO->getTitle());
//        $quiz->setCategory($quizDTO->getCategory());
        $quiz->setDescription($quizDTO->getDescription());
        $quiz->setCreatedAt();
//        $quiz->setAuthor();

        $question = new QuestionTransformer();
        foreach ($quizDTO->getQuestions() as $questionDTO)
        {
            $quiz->addQuestion( $question->transformQuestionDTO($questionDTO));
        }

        return $quiz;
    }
}
