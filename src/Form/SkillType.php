<?php

namespace App\Form;

use App\Entity\Skill;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class , [
                'attr' => array('style' => 'width: 200px','style' => 'font-size: 1.2em')
            ])
            //->add('image')
            ->add('description' , TextType::class , [
                'label' => 'Description of the skill',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('skdgt', IntegerType::class , [
                'label' => 'Damage Success',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('skmana', IntegerType::class , [
                'label' => 'Mana Success',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('skatk', IntegerType::class , [
                'label' => 'Success Attack',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('skesq', IntegerType::class , [
                'label' => 'Dodging Success',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('skdef', IntegerType::class , [
                'label' => 'Defence Success',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('skhp', IntegerType::class , [
                'label' => 'Success Healing',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('dialsc', TextType::class , [
                'label' => 'Critical Success Dialogue',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('manasc', IntegerType::class , [
                'label' => 'Critical Success Attack Critical Success',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('atksc', IntegerType::class , [
                'label' => 'Damage Success Critical',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('dgtsc', IntegerType::class , [
                'label' => 'Mana Critical Success',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('esqsc', IntegerType::class , [
                'label' => 'Dodging Critical Success',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('defsc', IntegerType::class , [
                'label' => 'Defence Success Critical',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('hpsc', IntegerType::class , [
                'label' => 'Critical Success Healing',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('dialec', TextType::class , [
                'label' => 'Critical Failure Dialog',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('dgtec', IntegerType::class , [
                'label' => 'Damage Critical Failure',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('manaec', IntegerType::class , [
                'label' => 'Mana Critical Failure',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('atkec', IntegerType::class , [
                'label' => 'Attack Critical Failure',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('esqec', IntegerType::class , [
                'label' => 'Dodge Critical Failure',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('defec', IntegerType::class , [
                'label' => 'Defense Critical Failure',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('hpec', IntegerType::class , [
                'label' => 'Critical Failure Healing',
                'attr' => array('style' => 'width: 250px;font-size: 1.2em')
            ])
            ->add('imageFile', VichFileType::class, [
                'download_link'     => false,
                'required'          => false,
                'delete_label'          => false,
                'allow_delete' => false,
                'download_label' => false,
                'download_uri' => false,
                //'image_uri' => false,
                  
                'constraints' => [
                    new Image([
                         'mimeTypesMessage' => 'Please upload a valid Png/jpeg/jpg or Csv/xml',
                        'mimeTypes' => ['image/jpg', 'image/jpeg', 'image/png', ]
                    ])
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'save',
                'attr' => [
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Skill::class,
        ]);
    }
}
