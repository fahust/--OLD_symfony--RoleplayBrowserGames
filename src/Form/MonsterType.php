<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Monster;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Symfony\Component\Form\AbstractType;
//use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MonsterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,  [
                'attr' => array('style' => 'width: 200px')])
            ->add('hp', IntegerType::class , [
                'label' => 'Life monster',
                //'attr' => array('style' => 'width: 250px')
            ])
            ->add('atk', IntegerType::class , [
                'label' => 'Attack monster',
                //'attr' => array('style' => 'width: 250px')
            ])
            ->add('dgt', IntegerType::class , [
                'label' => 'Damage monster',
                //'attr' => array('style' => 'width: 250px')
            ])
            ->add('esq', IntegerType::class , [
                'label' => 'Dodge monster',
                //'attr' => array('style' => 'width: 250px')
            ])
            ->add('def', IntegerType::class , [
                'label' => 'Defence monster',
                //'attr' => array('style' => 'width: 250px')
            ])
            ->add('description',TextType::class,  [
                'label' => 'Monster description',
                'attr' => array('style' => 'height: 100px')])
            ->add('imageFile', VichFileType::class, [
                'label' => 'Monster image',
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
                'label' => 'Monster skill',
                'class' => Skill::class,
                'multiple' => true,
                'query_builder' => function (SkillRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                
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
                ])
            ->add('save', SubmitType::class, [
                'label' => 'save'
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
