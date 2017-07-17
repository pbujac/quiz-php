<?php

namespace AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueCategory extends Constraint
{
    /** @var string $message */
    public $message = 'Category already exist!';
}

