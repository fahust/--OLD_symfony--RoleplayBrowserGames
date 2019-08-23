<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Monster;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Symfony\Component\Form\AbstractType;
//use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\PropertyAccess\PropertyPath;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
