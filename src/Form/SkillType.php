<?php

namespace App\Form;

use App\Entity\Skill;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
//use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class , [
                'attr' => array('style' => 'width: 200px')
            ])
            //->add('image')
            ->add('description' , TextType::class , [
                'label' => 'Description de la compétence',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('skdgt', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('skmana', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('skatk', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('skesq', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('skdef', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('skhp', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('dialsc', TextType::class , [
                'label' => 'Dialogue de succès critique',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('manasc', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('atksc', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('dgtsc', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('esqsc', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('defsc', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('hpsc', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('dialec', TextType::class , [
                'label' => 'Dialogue d\'echec critique',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('dgtec', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('manaec', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('atkec', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('esqec', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('defec', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
            ])
            ->add('hpec', IntegerType::class , [
                'attr' => array('style' => 'width: 250px')
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
