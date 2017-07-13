<?php

namespace AdminBundle\Validator\Constraints;

use AdminBundle\Validator\CategoryValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CategoryConstraint extends Constraint
{
    /** @var string */
    public $message = 'Category already exist!';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return CategoryValidator::class;
    }
}
