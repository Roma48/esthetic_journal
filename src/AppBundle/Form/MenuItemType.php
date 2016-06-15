<?php

namespace AppBundle\Form;

use AppBundle\Entity\MenuItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, [
                'label' => 'Заголовок',
                'attr' => ['class' => 'form-control']
            ])
            ->add("url", TextType::class, [
                'label' => 'Посилання',
                'attr' => ['class' => 'form-control']
            ])
            ->add("parent", EntityType::class, [
                'class' => 'AppBundle\Entity\MenuItem',
                'choice_label' => function(MenuItem $menuItem){
                    if (!$menuItem->getParent()){
                        return $menuItem->getTitle();
                    } else {
                        return '-- ' . $menuItem->getTitle();
                    }
                },
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
            'data_class' => 'AppBundle\Entity\MenuItem'
        ]);
    }
    public function getName()
    {
        return 'menu_item';
    }
}