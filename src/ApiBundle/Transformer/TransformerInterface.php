<?php

namespace ApiBundle\Transformer;

interface TransformerInterface
{
    /**
     * @param $entity
     *
     * @return object
     */
    public function transform($entity);

    /**
     * @param $dto
     * @param $entity
     *
     * @return object
     */
    public function reverseTransform($dto, $entity = null);

    /**
     * @return string
     */
    public function getEntityClass(): string;

}
