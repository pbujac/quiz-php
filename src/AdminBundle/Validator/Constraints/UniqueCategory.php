<?php

namespace AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueCategory extends Constraint
{
    /** @param string $message */
    public $message = 'Category already exist!';
}

