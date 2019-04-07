<?php

namespace App\Form;

use App\Entity\Skill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('image')
            ->add('description')
            ->add('skdgt')
            ->add('skmana')
            ->add('skatk')
            ->add('skesq')
            ->add('skdef')
            ->add('skhp')
            ->add('dialsc')
            ->add('manasc')
            ->add('atksc')
            ->add('dgtsc')
            ->add('esqsc')
            ->add('defsc')
            ->add('hpsc')
            ->add('dialec')
            ->add('dgtec')
            ->add('manaec')
            ->add('atkec')
            ->add('esqec')
            ->add('defec')
            ->add('hpec')
            ->add('save', SubmitType::class, [
                'label' => 'enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Skill::class,
        ]);
    }
}
