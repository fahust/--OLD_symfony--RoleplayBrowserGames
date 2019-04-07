<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Monster;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class MonsterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('hp')
            ->add('atk')
            ->add('dgt')
            ->add('esq')
            ->add('def')
            ->add('description')
            ->add('image')
            ->add('skillbdd', EntityType::class, [
                'class' => Skill::class,
                'multiple' => true,
                'query_builder' => function (SkillRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                
            ])
            /*->add('skillbdd', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'name'
            ])*/
            ->add('save', SubmitType::class, [
                'label' => 'enregistrer'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Monster::class,
        ]);
    }
}
