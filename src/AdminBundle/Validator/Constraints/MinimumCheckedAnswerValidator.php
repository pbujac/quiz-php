<?php

namespace AdminBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MinimumCheckedAnswerValidator extends ConstraintValidator
{
    /**
     * @param $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        dump($value);
//        $intArray = [];
//        foreach ($value->getSnapshot() as $answer) {
//            $intArray[] = $answer->isCorrect();
//        }
//
//        if (!in_array(true, $intArray)) {
//            $this->context->buildViolation($constraint->message)
//                ->addViolation();
//        }
    }
}
