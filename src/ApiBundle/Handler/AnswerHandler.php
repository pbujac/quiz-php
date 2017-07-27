<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\AnswerDTO;
use AppBundle\Entity\Answer;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnswerHandler
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
     * @param AnswerDTO $answerDTO
     */
    public function loginHandler(AnswerDTO $answerDTO)
    {
        $errors = $this->validator->validate($answerDTO);

        if (count($errors) > 0) {
            throw new BadRequestHttpException();
        }

    }
}
