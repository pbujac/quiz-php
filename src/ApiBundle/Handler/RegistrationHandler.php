<?php

namespace ApiBundle\Handler ;

use ApiBundle\DTO\RegistrationDTO ;
use AppBundle\Entity\User;
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
        $user= new User();

        $user->setUsername($registrationDTO->getUsername());
        $user->setPassword($registrationDTO->getPassword());
        $user->setFirstName($registrationDTO->getFirstName());
        $user->setLastName($registrationDTO->getLastName());
        $user->setActive(true);

        $em=$this->em ;
        $em->persist($user);
        $em->flush();

    }
}
