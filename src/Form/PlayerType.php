<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
//use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\HttpFoundation\File\UploadedFile;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class , [
            'attr' => array('style' => 'width: 200px')
        ])
        ->add('skillbdd', EntityType::class, [
            'class' => Skill::class,
            //'choices' => $skill,
            'multiple' => true,
            'choice_label' => 'name',
        ])
        ->add('level', HiddenType::class)
        ->add('experience', HiddenType::class)
        ->add('skillpnt', HiddenType::class)
        ->add('hp', HiddenType::class)
        ->add('atk', HiddenType::class)
        ->add('image', HiddenType::class)
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
            'data_class' => Player::class,
        ]);
    }
}
