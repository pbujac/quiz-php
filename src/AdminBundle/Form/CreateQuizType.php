<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Count;

class CreateQuizType extends BaseQuizType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('questions', CollectionType::class, [
            'entry_type' => QuestionType::class,
            'by_reference' => false,
            'prototype' => true,
            'allow_add' => true,
            'allow_delete' => true,
            'constraints' => [
                new Count([
                    'min' => 1,
                    'minMessage' => 'You must specify at least one question',
                ]),
            ]
        ]);
    }

}
