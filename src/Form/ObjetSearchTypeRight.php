<?php

namespace App\Form;

use App\Entity\ObjetSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ObjetSearchTypeRight extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nameAsc', CheckboxType::class, [
            'label'    => 'Ascending name',
            'required' => false,
            'attr' => [
                'style' => 'font-size: 1.2em'
            ]
        ])
        ->add('nameDesc', CheckboxType::class, [
            'label'    => 'Descending name',
            'required' => false,
            'attr' => [
                'style' => 'font-size: 1.2em'
            ]
        ])
        ->add('likeAsc', CheckboxType::class, [
            'label'    => 'Ascending like',
            'required' => false,
            'attr' => [
                'style' => 'font-size: 1.2em'
            ]
        ])
        ->add('likeDesc', CheckboxType::class, [
            'label'    => 'Descending like',
            'required' => false,
            'attr' => [
                'style' => 'font-size: 1.2em'
            ]
        ])
        ->add('dateAsc', CheckboxType::class, [
            'label'    => 'Ascending date',
            'required' => false,
            'attr' => [
                'style' => 'font-size: 1.2em'
            ]
        ])
        ->add('dateDesc', CheckboxType::class, [
            'label' => 'Descending date',
            'required' => false,
            'attr' => [
                'style' => 'font-size: 1.2em'
            ]
        ])
        ->add('createdByMe', CheckboxType::class, [
            'label' => 'Created By Me',
            'required' => false,
            'attr' => [
                'style' => 'font-size: 1.2em'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ObjetSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    //ne rempli pas form apres actualisation mais evite longue recherche
    public function getBlockPrefix()
    {
        return '';
    }
}
