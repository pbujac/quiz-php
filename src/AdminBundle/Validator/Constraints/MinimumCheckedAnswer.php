<?php

namespace AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class MinimumCheckedAnswer extends Constraint
{
    /** @param string $message */
    public $message = 'You must have minimum one checked answer!';
}
