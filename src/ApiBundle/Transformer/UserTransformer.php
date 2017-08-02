<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\RegistrationDTO;
use ApiBundle\DTO\UserDTO;
use AppBundle\Entity\User;

class UserTransformer
{
    /**
     * @param RegistrationDTO $registrationDTO
     *
     * @return User
     */
    public function reverseTransform(RegistrationDTO $registrationDTO): User
    {
        $user = new User();
        $user->setUsername($registrationDTO->username);
        $user->setPassword($registrationDTO->password);
        $user->setFirstName($registrationDTO->firstName);
        $user->setLastName($registrationDTO->lastName);
        $user->setActive(true);
        $user->addRole('ROLE_USER');

        return $user;
    }

    /**
     * @param User $user
     *
     * @return UserDTO
     */
    public function transform(User $user)
    {
        $userDTO = new UserDTO();

        $userDTO->id = $user->getId();
        $userDTO->username = $user->getUsername();
        $userDTO->lastName = $user->getLastName();
        $userDTO->firstName = $user->getFirstName();
        $userDTO->active = $user->isActive();
        $userDTO->roles = $user->getRoles();
        $userDTO->createdAt = $user->getCreatedAt()->getTimestamp();

        return $userDTO;
    }

}
