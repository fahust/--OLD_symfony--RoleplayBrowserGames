<?php

namespace App\Form;

use App\Entity\QuestVariable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FightType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',TextType::class)
        ->add('hp',TextType::class)
        ->add('atk',TextType::class)
        ->add('dgt',TextType::class)
        ->add('esq',TextType::class)
        ->add('def',TextType::class)
        ->add('description',TextType::class)
        ->add('image',TextType::class)
        ->add('save', SubmitType::class, [
            'label' => 'continuer'
        ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuestVariable::class,
        ]);
    }
}
