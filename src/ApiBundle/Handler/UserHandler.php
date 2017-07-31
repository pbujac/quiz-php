<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\UserDTO;
use ApiBundle\Transformer\UserTransformer;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserHandler
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var UserTransformer $userTransformer */
    private $userTransformer;

    /**
     * @param EntityManagerInterface $em
     * @param UserTransformer $userTransformer
     */
    public function __construct(EntityManagerInterface $em, UserTransformer $userTransformer)
    {
        $this->em = $em;
        $this->userTransformer = $userTransformer;
    }


    /**
     * @param User $user
     *
     * @return UserDTO
     */
    public function handleGetUser(User $user): UserDTO
    {
        return $this->userTransformer->reverseTransform($user);
    }

    /**
     * @param UserDTO $userDTO
     * @param User $user
     *
     * @return User
     */
    public function putUser(UserDTO $userDTO, User $user): User
    {
        $userDTO = $this->userTransformer->transform($userDTO, $user);

        $this->em->flush();

        return $userDTO;
    }
}
