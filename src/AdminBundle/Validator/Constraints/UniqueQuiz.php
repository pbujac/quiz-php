<?php

namespace AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueQuiz extends Constraint
{
    /** @var string $message */
    public $message = 'Quiz already exist!';
}
