<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", TextType::class, [
                'label' => 'Назва',
                'attr' => ['class' => 'form-control']
            ])
            ->add("description", TextareaType::class, [
                'label' => 'Опис',
                'attr' => ['class' => 'form-control']
            ])
            ->add("file", FileType::class, [
                'label' => 'Картинка',
                'attr' => ['class' => 'form-control']
            ])
            ->add("class", TextType::class, [
                'label' => 'Css class',
                'attr' => ['class' => 'form-control']
            ])
            ->add("parent", EntityType::class, [
                'class' => 'AppBundle\Entity\Category',
                'query_builder' => function(EntityRepository $em){
                    return $em->createQueryBuilder('c')
                        ->where('c.parent = 0');
                },
                'choice_label' => 'name',
                'placeholder' => ' ',
                'label' => 'Parent',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Category'
        ]);
    }
    public function getName()
    {
        return 'category';
    }
}