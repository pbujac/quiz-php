<?php

namespace AdminBundle\Form;

use AppBundle\Entity\User;
use AdminBundle\Validator\UserValidator;
use AdminBundle\Validator\Constraints\UserConstraint;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
                        new UserConstraint(),
                    ]
                ]
            )
            ->add('password', PasswordType::class)
            ->add('active', RadioType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('roles', ChoiceType::class, [
                'choices' => array(
                    'ROLE_ADMIN' => User::ROLE_ADMIN,
                    'ROLE_MANAGER' => User::ROLE_MANAGER,
                    'ROLE_USER' => User::ROLE_USER,
                ),
                'multiple' => true,
                'constraints' => [
                    new Count(['max' => 1])
                ],
            ]);

    }

    /**
     * @param OptionsResolver $resolver
     */

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
