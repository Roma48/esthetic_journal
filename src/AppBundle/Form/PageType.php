<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, [
                'label' => 'Заголовок',
                'attr' => ['class' => 'form-control']
            ])
            ->add("file", FileType::class, [
                'label' => 'Картинка',
                'attr' => ['class' => 'form-control']
            ])
            ->add("content", TextareaType::class, [
                'label' => 'Повний текст',
                'attr' => ['class' => 'form-control']
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Page'
        ]);
    }
    public function getName()
    {
        return 'page';
    }
}