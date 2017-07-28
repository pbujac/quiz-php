<?php

namespace AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotEmptyAnswerValidator extends ConstraintValidator
{
    /**
     * @param $answers[]
     * @param Constraint $constraint
     */
    public function validate($answers, Constraint $constraint)
    {
        $answersTemp = [];
        foreach ($answers as $answer) {
            $answersTemp[] = $answer->isCorrect();
        }

        if (!in_array(true, $answersTemp)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
