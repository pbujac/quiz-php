<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\RegistrationDTO;
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

}
