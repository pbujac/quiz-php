<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\UserDTO;
use AppBundle\Entity\User;

class UserTransformer
{
    public function transformUserDTO(UserDTO $userDTO)
    {
        $user = new User();
        $user->setUsername($userDTO->username);
        $user->setPassword($userDTO->password);
        $user->setFirstName($userDTO->firstName);
        $user->setLastName($userDTO->lastName);
        $user->setActive(true);
        $user->addRole('ROLE_USER');

        return $user;
    }
    public function transformUserObj(User $user)
    {
        $userDTO = new UserDTO();
        $userDTO->id = $user->getId();
        $userDTO->username = $user->getUsername();
        $userDTO->lastName = $user->getLastName();
        $userDTO->firstName = $user->getFirstName();

        return $userDTO;
    }
}
