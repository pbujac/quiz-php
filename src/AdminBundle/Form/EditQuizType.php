<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class EditQuizType extends BaseQuizType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

}
