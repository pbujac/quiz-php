<?php

namespace ApiBundle\Handler;

use ApiBundle\DTO\RegistrationDTO;
use ApiBundle\Transformer\UserTransformer;
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
     * @param UserTransformer $userTransformer
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $em,
                                UserTransformer $userTransformer,
                                ValidatorInterface $validator
    ){
        $this->em = $em;
        $this->transformUser=$userTransformer;
        $this->validator = $validator;
    }

    /**
     * @param RegistrationDTO $registrationDTO
     */
    public function handleRegistration(RegistrationDTO $registrationDTO)
    {
        $this->validateRegistrationDTO($registrationDTO);

        $this->em->persist(
            $this->transformUser->transformRegistrationDTO($registrationDTO)
            );
        $this->em->flush();
    }

    public function validateRegistrationDTO(RegistrationDTO $registrationDTO)
    {
        $errors = $this->validator->validate($registrationDTO);

        if (count($errors)>0)
        {
            $mesage="";
            foreach ($errors as $violation)
            {
                $mesage = $violation->getPropertyPath().'-'.$violation->getMessage();
            }
            throw new BadRequestHttpException($mesage);
        }
    }

}
