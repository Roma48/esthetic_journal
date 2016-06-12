<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SlideType
 * @package AppBundle\Form
 */
class SlideType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, [
                'label' => 'Заголовок',
                'attr' => ['class' => 'form-control']
            ])
            ->add("description", TextType::class, [
                'label' => 'Опис',
                'attr' => ['class' => 'form-control']
            ])
            ->add("file", null, [
                'label' => 'Картинка',
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Slide'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'slide';
    }
}