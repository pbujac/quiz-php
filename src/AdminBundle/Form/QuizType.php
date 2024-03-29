<?php

namespace AdminBundle\Form;

use AdminBundle\Validator\Constraints\UniqueQuiz;
use AppBundle\Entity\Category;
use AppBundle\Entity\Quiz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                    new UniqueQuiz(),
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'title',
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 5000]),
                ]
            ])
            ->add('questions', CollectionType::class, [
                'entry_type' => QuestionType::class,
                'prototype' => true,
                'allow_add' => true,
                'attr' => [
                    'class' => 'quiz-questions'
                ],
                'constraints' => [
                    new Count([
                        'min' => 1,
                        'minMessage' => 'You must specify at least one question',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
