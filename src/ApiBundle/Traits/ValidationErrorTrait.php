<?php

namespace ApiBundle\Traits;

use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;

trait ValidationErrorTrait
{

    /**
     * @param ConstraintViolationListInterface $errors
     *
     * @return string
     */
    public function getErrorMessage(ConstraintViolationListInterface $errors)
    {
        $serializer = SerializerBuilder::create()->build();

        $errorMessage = [
            'reason' => 'validationError',
            'message' => 'error.validation',
            'description' => 'Validation error:'
        ];

        foreach ($errors as $error) {
            $errorMessage = array_merge($errorMessage, $this->setErrorDetails($error));
        }

        return $serializer->serialize($errorMessage, 'json');
    }

    /**
     * @param ConstraintViolation $error
     *
     * @return array
     */
    public function setErrorDetails(ConstraintViolation $error)
    {
        return $detailsError = [
            $error->getPropertyPath() => [
                'reason' => $error->getPropertyPath(),
                'message' => $error->getMessage(),
            ]
        ];
    }
}
