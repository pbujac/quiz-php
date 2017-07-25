<?php

namespace ApiBundle\Handler ;

use ApiBundle\DTO\RegistrationDTO ;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationHandler
{
    /** @var EntityManagerInterface $em */
    private $em ;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param RegistrationDTO $registrationDTO
     */
    public function handleRegistration (RegistrationDTO $registrationDTO)
    {
        $user= new RegistrationDTO ;
        $user->setUsername('1');
        $user->setPassword('2');
        $user->setFirstName('3');
        $user->setLastName('4');

        $this->em->persist($user);
        $this->em->flush();

    }
}
