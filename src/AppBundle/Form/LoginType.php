<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("firstName", TextType::class, [
                'label' => 'First Name',
                'attr' => ['class' => 'form-control']
            ])
            ->add("lastName", TextareaType::class, [
                'label' => 'Last Name',
                'attr' => ['class' => 'form-control']
            ])
            ->add("age", IntegerType::class, [
                'label' => 'Age',
                'attr' => ['class' => 'form-control']
            ])
//            ->add("birthDay", DateTimeType::class, [
//                'label' => 'Birth day',
//                'attr' => ['class' => 'form-control']
//            ])
            ->add('username', TextType::class, [
                'label' => 'Username',
                'attr' => ['class' => 'form-control']
            ])
            ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options'  => array(
                        'label' => 'Password',
                        'attr' => ['class' => 'form-control']
                    ),
                    'second_options' => array(
                        'label' => 'Repeat Password',
                        'attr' => ['class' => 'form-control']
                    ),

                )
            );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User'
        ]);
    }
    public function getName()
    {
        return 'register';
    }
}