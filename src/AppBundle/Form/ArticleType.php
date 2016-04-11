<?php

namespace AppBundle\Form;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, [
                'label' => 'Заголовок',
                'attr' => ['class' => 'form-control']
            ])
            ->add("description", TextareaType::class, [
                'label' => 'Опис',
                'attr' => ['class' => 'form-control']
            ])
            ->add("content", TextareaType::class, [
                'label' => 'Повна версія',
                'attr' => ['class' => 'form-control']
            ])
            ->add("image", ImageType::class, [
                'label' => ' '
            ])
            ->add("categories", EntityType::class, [
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control'],
                'class' => 'AppBundle\Entity\Category',
                'label' => 'Категорія'
            ])
            ->add("users", EntityType::class, [
                'choice_label' => 'firstName',
                'attr' => ['class' => 'form-control'],
                'class' => 'AppBundle\Entity\User',
                'label' => 'Користувач'
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Article'
        ]);
    }
    public function getName()
    {
        return 'article';
    }
}