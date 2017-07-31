<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\UserDTO;
use ApiBundle\Transformer\UserTransformer;
use AppBundle\Entity\User;

class QuizHandler
{
    /** @var UserTransformer $userTransformer */
    private $userTransformer;

    /**
     * @param UserTransformer $userTransformer
     */
    public function __construct(UserTransformer $userTransformer)
    {
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
}
