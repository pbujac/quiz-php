<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\UserDTO;
use ApiBundle\Traits\ValidationErrorTrait;
use ApiBundle\Transformer\UserTransformer;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserHandler
{
    use ValidationErrorTrait;

    /** @var EntityManagerInterface $em */
    private $em;

    /** @var ValidatorInterface */
    private $validator;

    /** @var UserTransformer $userTransformer */
    private $userTransformer;

    /**
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param UserTransformer $userTransformer
     */
    public function __construct(
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        UserTransformer $userTransformer
    ) {
        $this->em = $em;
        $this->validator = $validator;
        $this->userTransformer = $userTransformer;
    }

    /**
     * @param User $user
     *
     * @return UserDTO
     */
    public function handleGetUser(User $user): UserDTO
    {
        return $this->userTransformer->transform($user);
    }

    /**
     * @param UserDTO $userDTO
     * @param User $user
     */
    public function handlePutUser(UserDTO $userDTO, User $user)
    {
        $this->validateUserDTO($userDTO);

        $this->userTransformer->reverseTransform(
            $userDTO,
            $user
        );

        $this->em->flush();
    }

    /**
     * @param UserDTO $userDTO
     */
    private function validateUserDTO(UserDTO $userDTO): void
    {
        $errors = $this->validator->validate($userDTO);

        if (count($errors) > 0) {
            $errorMessage = $this->getErrorMessage($errors);

            throw new BadRequestHttpException($errorMessage);
        }
    }
}
