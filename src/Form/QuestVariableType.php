<?php

namespace App\Form;

use App\Entity\Objet;
use App\Entity\Monster;
use App\Entity\QuestVariable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichFileType;
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
                'attr' => array('style' => 'width: 200px','style' => 'font-size: 1.2em')
            ])
            ->add('titlezone', TextType::class , [
                'label' => 'Name of the place',
                'attr' => array('style' => 'font-size: 1.2em')
            ])
            ->add('description', TextType::class , [
                'label' => 'Quest Description',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            /*->add('image', TextType::class , [
                'label' => 'Image de la quête'
            ])*/
            ->add('initiative', TextType::class , [
                'label' => 'Dialog Initiative',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('dedifficult', TextType::class , [
                'label' => 'Quest Difficulty',
                'attr' => array('style' => 'font-size: 1.2em')
            ])
            ->add('dialreussitenego', TextType::class , [
                'label' => 'Dialog Negotiation Success',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('dialoguedereussitepersu', TextType::class , [
                'label' => 'Dialog Persuasion Success',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('dialoguedereussitetaunt', TextType::class , [
                'label' => 'Dialog Threat Success',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('dialoguedereussitenawak', TextType::class , [
                'label' => 'Dialog Chance Success',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('dialoguededefaitenego', TextType::class , [
                'label' => 'Dialog Negotiation Failure',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('dialoguededefaitepersu', TextType::class , [
                'label' => 'Dialog Persuasion Failure',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('dialoguededefaitetaunt', TextType::class , [
                'label' => 'Dialog of Threat Failure',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('dialoguededefaitenawak', TextType::class , [
                'label' => 'Dialog of Chance Failed',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('dialoguedereussitefin', TextType::class , [
                'label' => 'Dialogue de réussite de fin de quête',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('dialoguededefaitefin', TextType::class , [
                'label' => 'Dialogue de défaite de fin de quête',
                'attr' => array('style' => 'height: 100px;font-size: 1.2em')
            ])
            ->add('questrequismany', EntityType::class ,[
                'label' => 'Objet de quête requis pour lancer la quête',
                'class' => (Objet::class),
                'choice_label' => 'name',
                'placeholder' => 'nothing2',
                'required'      => false,
                'attr' => array('font-size: 1.2em')
                //'choice_value' => 'nothing'
                ])
            ->add('objetreussite', EntityType::class ,[
                    'label' => 'Objet gagné en cas de victoire',
                    'class' => (Objet::class),
                    'choice_label' => 'name',
                    'multiple' => true,
                    'placeholder' => 'nothing2',
                    'required'      => false,
                    'attr' => array('font-size: 1.2em')
                    //'choice_value' => 'nothing'
                    ])
            
            
            ->add('monsters', EntityType::class ,[
                'class' => Monster::class,
                'multiple' => true,
                'choice_label' => 'name',
                'attr' => array('font-size: 1.2em')
                ])
            ->add('imageFile', VichFileType::class, [
                'download_link'     => false,
                'required'          => false,
                'delete_label'          => false,
                'allow_delete' => false,
                'download_label' => false,
                'download_uri' => false,
                'attr' => array('font-size: 1.2em'),
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
                        'attr' => array('font-size: 1.2em')
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
                        'attr' => array('font-size: 1.2em')
                    ])
            
            ->add('save', SubmitType::class, [
                'label' => 'save',
                'attr' => array('font-size: 1.2em')
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
