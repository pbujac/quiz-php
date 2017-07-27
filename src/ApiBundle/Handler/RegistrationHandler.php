<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\RegistrationDTO;
use ApiBundle\Transformer\RegistrationTransformer;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationHandler
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * @param EntityManagerInterface $em
     * @param RegistrationTransformer $registrationTransformer
     */
    public function __construct(EntityManagerInterface $em, RegistrationTransformer $registrationTransformer)
    {
        $this->em = $em;
        $this->transformRegistration=$registrationTransformer;
    }

    /**
     * @param RegistrationDTO $registrationDTO
     */
    public function handleRegistration(RegistrationDTO $registrationDTO)
    {
        $this->em->persist(
            $this->transformRegistration->transformRegistrationDTO($registrationDTO)
            );
        $this->em->flush();
    }

}
