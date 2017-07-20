<?php

namespace AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueQuiz extends Constraint
{
    /** @param string $message */
    public $message = 'Quiz already exist!';
}
