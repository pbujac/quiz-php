<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\UserDTO;
use ApiBundle\Traits\ValidationErrorTrait;
use ApiBundle\Transformer\UserTransformer;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
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
     * @param string|null $username
     *
     * @return UserDTO
     */
    public function handleGetUserByUsername(string $username = ''): UserDTO
    {
        $user = $this->em->getRepository(User::class)
            ->findOneBy([
                'username' => $username,
            ]);

        if (!$user) {
            $error = new ConstraintViolation(
                'User with username: ' . $username . ' does not exist',
                '', [],
                null,
                'username',
                'username'
            );
            $errors = new ConstraintViolationList();
            $errors->add($error);

            $errorMessage = $this->getErrorMessage($errors);

            throw new BadRequestHttpException($errorMessage);
        }
        $userDTO = $this->userTransformer->transform($user);

        return $userDTO;
    }

    /**
     * @param UserDTO $userDTO
     */
    public function handleRegistration(UserDTO $userDTO): void
    {
        $this->validateUserDTO($userDTO);

        $user = $this->userTransformer->reverseTransform($userDTO);

        $this->em->persist($user);
        $this->em->flush();
    }


    /**
     * @param UserDTO $userDTO
     * @param User $user
     */
    public function handlePutUser(UserDTO $userDTO, User $user): void
    {
        $this->userTransformer->reverseTransform($userDTO, $user);

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
