<?php

namespace ApiBundle\Handler ;

use ApiBundle\DTO\RegistrationDTO ;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationHandler
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    /**
     * @param RegistrationDTO $registrationDTO
     */
    public function handleRegistration (RegistrationDTO $registrationDTO)
    {
        $user= new User();

        $user->setUsername($registrationDTO->username);
        $user->setPassword($registrationDTO->password);
        $user->setFirstName($registrationDTO->firstName);
        $user->setLastName($registrationDTO->lastName);
        $user->setActive(true);

        $this->em->persist($user);
        $this->em->flush();
    }
}
