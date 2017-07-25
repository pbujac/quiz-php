<?php

namespace ApiBundle\Handler ;

use ApiBundle\DTO\RegistrationDTO ;

class RegistrationHandler
{
    /**
     * @return RegistrationDTO $user
     */
    public function registrationHandler()
    {
        $user= new RegistrationDTO() ;
        $user->addUser();

        return $user ;
    }
}
