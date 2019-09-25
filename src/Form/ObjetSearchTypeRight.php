<?php

namespace App\Form;

use App\Entity\ObjetSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ObjetSearchTypeRight extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nameAsc', CheckboxType::class, [
            'label'    => '',
            'required' => false,
        ])
        ->add('nameDesc', CheckboxType::class, [
            'label'    => '',
            'required' => false,
        ])
        ->add('likeAsc', CheckboxType::class, [
            'label'    => '',
            'required' => false,
        ])
        ->add('likeDesc', CheckboxType::class, [
            'label'    => '',
            'required' => false,
        ])
        ->add('dateAsc', CheckboxType::class, [
            'label'    => '',
            'required' => false,
        ])
        ->add('dateDesc', CheckboxType::class, [
            'label'    => '',
            'required' => false,
        ])
        ->add('createdByMe', CheckboxType::class, [
            'label'    => '',
            'required' => false,
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
