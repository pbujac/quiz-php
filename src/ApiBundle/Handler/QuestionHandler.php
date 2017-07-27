<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\QuestionDTO;
use AppBundle\Entity\Question;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuestionHandler
{
    /** @var ValidatorInterface */
    private $validator;

    /**
     * AnswerHandler constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param QuestionDTO $questionDTO
     */
    public function loginHandler(QuestionDTO $questionDTO)
    {
        $errors = $this->validator->validate($questionDTO);

        if (count($errors) > 0) {
            throw new BadRequestHttpException();
        }

    }
}
