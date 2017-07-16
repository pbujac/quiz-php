<?php

namespace AdminBundle\Form;

use AdminBundle\Validator\Constraints\AnswerConstraint;
use AppBundle\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AnswerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('correct', CheckboxType::class, [
                'required' => false,
            ])
            ->add('delete', ButtonType::class, [
                'label' => 'Delete Answer',
                'attr' => [
                    'class' => 'btn btn-sm btn-danger remove-btn remove-answer'
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
