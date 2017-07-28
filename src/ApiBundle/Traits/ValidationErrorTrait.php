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
        $errorMessage = $this->generateErrorMessage($errors);

        return $serializer->serialize($errorMessage, 'json');
    }

    /**
     * @param ConstraintViolationListInterface $errors
     *
     * @return array
     */
    public function generateErrorMessage(ConstraintViolationListInterface $errors): array
    {
        $headerError = [
            'reason' => 'validationError',
            'message' => 'error.validation',
            'description' => 'Validation error'
        ];
        $detailsError = $this->getErrorDetails($errors);

        $errorMessage = array_merge($headerError, [
            'details' => $detailsError,
        ]);
        return $errorMessage;
    }

    /**
     * @param ConstraintViolationListInterface $errors
     *
     * @return array
     */
    public function getErrorDetails(ConstraintViolationListInterface $errors): array
    {
        $detailsError = [];

        foreach ($errors as $error) {
            $detailsError = array_merge($detailsError, $this->setErrorDetail($error));
        }

        return $detailsError;
    }

    /**
     * @param ConstraintViolation $error
     *
     * @return array
     */
    public function setErrorDetail(ConstraintViolation $error)
    {
        return $detailsError = [
            $error->getPropertyPath() => [
                'reason' => $error->getPropertyPath(),
                'message' => $error->getMessage(),
            ]
        ];
    }
}
