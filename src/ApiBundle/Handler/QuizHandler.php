<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuizDTO;
use ApiBundle\Transformer\QuizTransformer;
use AppBundle\Entity\Quiz;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuizHandler extends FOSRestController
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var ValidatorInterface */
    private $validator;

    /** @var QuizTransformer */
    private $quizTransformer;

    /**
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param QuizTransformer $quizTransformer
     */
    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        QuizTransformer $quizTransformer
    )
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->quizTransformer = $quizTransformer;
    }

    /**
     * @param int $page
     * @param ParamFetcher $paramFetcher
     *
     * @return ArrayCollection|QuizDTO[]
     */
    public function searchByFilter(int $page, ParamFetcher $paramFetcher)
    {
        $quizzes = $this->em->getRepository(Quiz::class)
            ->getQuizByQueryAndPage($paramFetcher, $page);

        return $this->transformQuizzes($quizzes);
    }

    /**
     * @param $quizzes
     * @return ArrayCollection
     */
    public function transformQuizzes($quizzes): ArrayCollection
    {
        $quizzesDTO = new ArrayCollection();
        foreach ($quizzes as $quiz) {
            $quizzesDTO->add(
                $this->quizTransformer->transform($quiz)
            );
        }
        return $quizzesDTO;
    }

    /**
     * @param QuizDTO $quizDTO
     */
    public function handleCreate(QuizDTO $quizDTO)
    {
        $this->validateQuizDTO($quizDTO);
        $this->em->persist($this->quizTransformer->transform($quizDTO));
        $this->em->flush();
    }

    /**
     * @param QuizDTO $quizDTO
     */
    public function validateQuizDTO(QuizDTO $quizDTO): void
    {
        $errors = $this->validator->validate($quizDTO);

        if (count($errors) > 0) {
            $errorMessage = "";
            foreach ($errors as $violation) {
                $errorMessage .= $violation->getPropertyPath() . '-' . $violation->getMessage();
            }
            throw new BadRequestHttpException($errorMessage);
        }
    }

    /**
     * @param Quiz $quiz
     *
     * @ParamConverter("quiz")
     */
    public function handleDelete(Quiz $quiz)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($quiz);
        $em->flush();

    }
}
