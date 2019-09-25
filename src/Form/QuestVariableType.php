<?php

namespace App\Form;

use App\Entity\Objet;
use App\Entity\Monster;
use App\Entity\QuestVariable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
//use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestVariableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class , [
                'label' => 'Quest title',
                'attr' => array('style' => 'width: 200px')
            ])
            ->add('titlezone', TextType::class , [
                'label' => 'Name of the place'
            ])
            ->add('description', TextType::class , [
                'label' => 'Quest Description',
                'attr' => array('style' => 'height: 100px')
            ])
            /*->add('image', TextType::class , [
                'label' => 'Image de la quête'
            ])*/
            ->add('initiative', TextType::class , [
                'label' => 'Dialog Initiative',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('dedifficult', TextType::class , [
                'label' => 'Quest Difficulty'
            ])
            ->add('dialreussitenego', TextType::class , [
                'label' => 'Dialog Negotiation Success',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('dialoguedereussitepersu', TextType::class , [
                'label' => 'Dialog Persuasion Success',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('dialoguedereussitetaunt', TextType::class , [
                'label' => 'Dialog Threat Success',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('dialoguedereussitenawak', TextType::class , [
                'label' => 'Dialog Chance Success',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('dialoguededefaitenego', TextType::class , [
                'label' => 'Dialog Negotiation Failure',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('dialoguededefaitepersu', TextType::class , [
                'label' => 'Dialog Persuasion Failure',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('dialoguededefaitetaunt', TextType::class , [
                'label' => 'Dialog of Threat Failure',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('dialoguededefaitenawak', TextType::class , [
                'label' => 'Dialog of Chance Failed',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('dialoguedereussitefin', TextType::class , [
                'label' => 'Dialogue de réussite de fin de quête',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('dialoguededefaitefin', TextType::class , [
                'label' => 'Dialogue de défaite de fin de quête',
                'attr' => array('style' => 'height: 100px')
            ])
            ->add('questrequismany', EntityType::class ,[
                'label' => 'Objet de quête requis pour lancer la quête',
                'class' => (Objet::class),
                'choice_label' => 'name',
                'placeholder' => 'nothing2',
                'required'      => false,
                //'choice_value' => 'nothing'
                ])
            ->add('objetreussite', EntityType::class ,[
                    'label' => 'Objet gagné en cas de victoire',
                    'class' => (Objet::class),
                    'choice_label' => 'name',
                    'multiple' => true,
                    'placeholder' => 'nothing2',
                    'required'      => false,
                    //'choice_value' => 'nothing'
                    ])
            
            
            ->add('monsters', EntityType::class ,[
                'class' => Monster::class,
                'multiple' => true,
                'choice_label' => 'name',
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
            'data_class' => QuestVariable::class,
        ]);
    }
}
