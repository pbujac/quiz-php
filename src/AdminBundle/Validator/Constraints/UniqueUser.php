<?php

namespace AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueUser extends Constraint
{
    /** @var string $message */
    public $message = 'This Username already exist!';
}

