<?php

namespace AdminBundle\Form;

use AdminBundle\Validator\Constraints\MinimCheckedAnswer;
use AppBundle\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextType::class,[
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 5000]),
                ]
            ])
            ->add('answers', CollectionType::class, [
                'entry_type' => AnswerType::class,
                'required' => true,
                'prototype' => true,
                'allow_add' => true,
                'attr' => [
                    'class' => 'question-answers'
                ],
                'constraints' => [
                    new Count(['min' => 2]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
