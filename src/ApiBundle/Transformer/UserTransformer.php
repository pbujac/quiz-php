<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\RegistrationDTO;
use AppBundle\Entity\User;

class UserTransformer
{
    public function reverseTransform(RegistrationDTO $registrationDTO)
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
