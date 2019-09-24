<?php

namespace App\Form;

use App\Entity\QuestSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class QuestSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxDeDifficult', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Difficulté maximal'
                ]
            ])
            ->add('minDeDifficult', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Difficulté minimal'
                ]
            ])
            /*->add('nameAsc', CheckboxType::class, [
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
            ->add('choiceNbrPerPage', ChoiceType::class, [
            'choices' => [
                    '3 par pages' => '3',
                    '6 par pages' => '6',
                    '9 par pages' => '9',
                    '12 par pages' => '12',
                    '15 par pages' => '15',
                    '18 par pages' => '18',
                ]
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuestSearch::class,
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
