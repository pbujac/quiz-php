<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\UserDTO;
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
     * @param UserDTO $registrationDTO
     */
    public function handleRegistration(UserDTO $registrationDTO)
    {
        $this->validateRegistrationDTO($registrationDTO);

        $this->em->persist(
            $this->transformRegistration->transformRegistrationDTO($registrationDTO)
            );
        $this->em->flush();
    }

    public function validateRegistrationDTO(UserDTO $registrationDTO)
    {
        $errors = $this->validator->validate($registrationDTO);

        if (count($errors)>0)
        {
            $mesage="";
            foreach ($errors as $violation)
            {
                $mesage = $violation->getPropertyPath().'-'.$violation->getMessage();
            }
            throw new BadRequestHttpException();
        }
    }

}
