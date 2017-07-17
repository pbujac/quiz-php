<?php

namespace AdminBundle\Form;

use AppBundle\Entity\User;
use AdminBundle\Validator\Constraints\UniqueUser;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                        new UniqueUser(),
                    ]
                ]
            )
            ->add('password', PasswordType::class, [
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 4]),
                    ]
                ]
            )
            ->add('active', CheckboxType::class)
            ->add('firstName', TextType::class, [
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ]
                ]
            )
            ->add('lastName', TextType::class, [
                    'required' => true,
                    'constraints' => [
                        new NotBlank(),
                    ]
                ]
            )
            ->add('roles', ChoiceType::class, [
                    'choices' => [
                        User::ROLE_ADMIN => User::ROLE_ADMIN,
                        User::ROLE_MANAGER => User::ROLE_MANAGER,
                        User::ROLE_USER => User::ROLE_USER,
                    ],
                    'multiple' => true,
                    'constraints' => [
                        new Count(['max' => 1]),
                    ],
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

