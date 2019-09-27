<?php

namespace App\Form;

use App\Entity\QuestSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class QuestSearchTypeLeft extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxDeDifficult', IntegerType::class, [
                'label' => 'Difficulty max.',
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Difficulty max.',
                    'style' => 'font-size: 1.2em'
                ]
            ])
            ->add('minDeDifficult', IntegerType::class, [
                'label' => 'Difficulty max.',
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Difficulty min.',
                    'style' => 'font-size: 1.2em'
                ]
            ])
            ->add('language', ChoiceType::class, [
                'choices' => [
                        '' => null,
                        'French' => 'french',
                        'English' => 'english',
                        'Spanish' => 'spanish',
                        'Italia' => 'italia',
                        'Deutsch' => 'deutsch',
                ],
                    'required' => false,
                    'attr' => [
                        'style' => 'font-size: 1.2em'
                    ]
                ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                        '' => null,
                        'Fantasy' => 'Fantasy',
                        'Dark' => 'Dark',
                        'Sf' => 'Sf',
                        'Medieval' => 'Medieval',
                        'Modern' => 'Modern',
                ],
                    'required' => false,
                    'attr' => [
                        'style' => 'font-size: 1.2em'
                    ]
                ])
            ->add('choiceNbrPerPage', ChoiceType::class, [
            'choices' => [
                    '' => null,
                    '3 par pages' => '3',
                    '6 par pages' => '6',
                    '9 par pages' => '9',
                    '12 par pages' => '12',
                    '15 par pages' => '15',
                    '18 par pages' => '18',
            ],
            'attr' => [
                'style' => 'font-size: 1.2em'
            ]
            ])
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
