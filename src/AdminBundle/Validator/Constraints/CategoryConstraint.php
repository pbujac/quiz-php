<?php

namespace AdminBundle\Validator\Constraints;

use AdminBundle\Validator\CategoryValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CategoryConstraint extends Constraint
{
    public $message = 'Category already exist!';

    public function validatedBy()
    {
        return CategoryValidator::class;
    }
}
