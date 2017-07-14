<?php

namespace AdminBundle\Form;

use AppBundle\Entity\Quiz;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:Category',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'title',
            ))
            ->add('description')
            ->add('questions', CollectionType::class, array(
                'entry_type' => QuestionType::class,
                'prototype' => true,
                'allow_add' => true,
                'attr' => [
                    'class' => 'quiz-question'
                ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Quiz::class,
            'allow_add' => true,
        ));
    }
}
