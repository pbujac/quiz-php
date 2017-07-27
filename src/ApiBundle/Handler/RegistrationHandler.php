<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\RegistrationDTO;
use ApiBundle\Transformer\RegistrationTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationHandler
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * @param EntityManagerInterface $em
     * @param RegistrationTransformer $registrationTransformer
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $em,
                                RegistrationTransformer $registrationTransformer,
                                ValidatorInterface $validator
    ){
        $this->em = $em;
        $this->transformRegistration=$registrationTransformer;
        $this->validator = $validator;
    }

    /**
     * @param RegistrationDTO $registrationDTO
     */
    public function handleRegistration(RegistrationDTO $registrationDTO)
    {
        $this->validateRegistrationDTO($registrationDTO);

        $this->em->persist(
            $this->transformRegistration->transformRegistrationDTO($registrationDTO)
            );
        $this->em->flush();
    }

    public function validateRegistrationDTO(RegistrationDTO $registrationDTO)
    {
        $errors = $this->validator->validate($registrationDTO);

        if (count($errors)>0)
        {
            $errorMesage="";
            foreach ($errors as $violation)
            {
                $errorMesage = $violation->getPropertyPath().'-'.$violation->getMessage();
            }
            throw new BadRequestHttpException();
        }
    }

}
