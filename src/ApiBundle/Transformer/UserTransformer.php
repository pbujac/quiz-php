<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\UserDTO;
use AppBundle\Entity\User;

class UserTransformer
{
    /**
     * @param User $user
     *
     * @return UserDTO
     */
    public function transformDTO(User $user)
    {
        $userDTO = new UserDTO();
        $userDTO->id = $user->getId();
        $userDTO->username = $user->getUsername();
        $userDTO->lastName = $user->getLastName();
        $userDTO->firstName = $user->getFirstName();

        return $userDTO;
    }
}
