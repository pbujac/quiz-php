<?php

namespace AdminBundle\Form;

use AppBundle\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('category', TextType::class, array('Yes' => 'category_yes',
                'No' => 'category_no' ))
//            ->add('author', UserType::class)
//            ->add('createdAt', DateTimeType::class)
            ->add('description', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Quiz::class,
        ));
    }
}
