<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\PropertyAccess\PropertyPath;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PlayerTypeCreate extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$builder
            ->add('name', HiddenType::class)
            ->add('level', HiddenType::class)
            ->add('experience', HiddenType::class)
            ->add('skillpnt', HiddenType::class)
            ->add('hp', HiddenType::class)
            ->add('atk', HiddenType::class)
            ->add('image', HiddenType::class)
            ->add('createdAt', HiddenType::class)
            ->add('skillbdd', HiddenType::class)
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
        ;*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
