<?php

namespace AdminBundle\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use AppBundle\Entity\User;

class UniqueUserValidator extends ConstraintValidator
{
    /** @param EntityManagerInterface $em */
    private $em;

    /** @param EntityManagerInterface $em */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $repository = $this->em->getRepository(User::class);
        $user = $repository->findOneBy([
            'username' => $value,
        ]);

        if ($user) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}


