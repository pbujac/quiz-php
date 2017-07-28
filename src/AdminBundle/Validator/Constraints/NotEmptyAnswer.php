<?php

namespace AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotEmptyAnswer extends Constraint
{
    /** @var string $message */
    public $message = 'You must specify at least one correct answer';
}

