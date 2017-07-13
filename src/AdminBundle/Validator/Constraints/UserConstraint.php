<?php

namespace AdminBundle\Validator\Constraints;

use AdminBundle\Validator\UserValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserConstraint extends Constraint
{
    /**
     * @param string $message
     */
    public $message = 'This Username already exist!';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return UserValidator::class;
    }
}

