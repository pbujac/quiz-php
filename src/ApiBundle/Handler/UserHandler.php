<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\UserDTO;
use ApiBundle\Transformer\UserTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserHandler
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param EntityManagerInterface $em
     * @param UserTransformer $userTransformer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        EntityManagerInterface $em,
        UserTransformer $userTransformer,
        ValidatorInterface $validator
    ) {
        $this->em = $em;
        $this->userTransformer = $userTransformer;
        $this->validator = $validator;
    }

    /**
     * @param UserDTO $userDTO
     */
    public function handleRegistration(UserDTO $userDTO)
    {
        $this->validateRegistrationDTO($userDTO);

        $this->em->persist(
            $this->userTransformer->transformUserDTO($userDTO)
        );
        $this->em->flush();
    }

    public function validateRegistrationDTO(UserDTO $userDTO)
    {
        $errors = $this->validator->validate($userDTO);

        if (count($errors) > 0) {
            $mesage = "";
            foreach ($errors as $violation) {
                $mesage = $violation->getPropertyPath() . '-' . $violation->getMessage();
            }
            throw new BadRequestHttpException();
        }
    }

}
