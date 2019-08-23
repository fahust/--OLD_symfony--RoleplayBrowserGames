<?php

namespace App\Form;

use App\Entity\Objet;
use App\Entity\Monster;
use App\Entity\QuestVariable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\ObjetRepository;

class QuestVariableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class , [
                'label' => 'Titre de la quête'
            ])
            ->add('titlezone', TextType::class , [
                'label' => 'Nom du lieu de la quête'
            ])
            ->add('description', TextType::class , [
                'label' => 'Description de quête'
            ])
            ->add('image', TextType::class , [
                'label' => 'Image de la quête'
            ])
            ->add('initiative', TextType::class , [
                'label' => 'Initiative de la quête'
            ])
            ->add('dedifficult', TextType::class , [
                'label' => 'Difficulté des dé de la quête'
            ])
            ->add('dialreussitenego', TextType::class , [
                'label' => 'Dialogue de réussite de négociation'
            ])
            ->add('dialoguedereussitepersu', TextType::class , [
                'label' => 'Dialogue de réussite de persuation'
            ])
            ->add('dialoguedereussitetaunt', TextType::class , [
                'label' => 'Dialogue de réussite de menace'
            ])
            ->add('dialoguedereussitenawak', TextType::class , [
                'label' => 'Dialogue de réussite de chance'
            ])
            ->add('dialoguededefaitenego', TextType::class , [
                'label' => 'Dialogue de défaite de négociation'
            ])
            ->add('dialoguededefaitepersu', TextType::class , [
                'label' => 'Dialogue de défaite de persuation'
            ])
            ->add('dialoguededefaitetaunt', TextType::class , [
                'label' => 'Dialogue de défaite de menace'
            ])
            ->add('dialoguededefaitenawak', TextType::class , [
                'label' => 'Dialogue de défaite de chance'
            ])
            ->add('dialoguedereussitefin', TextType::class , [
                'label' => 'Dialogue de réussite de fin de quête'
            ])
            ->add('dialoguededefaitefin', TextType::class , [
                'label' => 'Dialogue de défaite de fin de quête'
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
                    ]);
            
            
            ->add('monsters', EntityType::class ,[
                'class' => Monster::class,
                'multiple' => true,
                'choice_label' => 'name',
                ])
            
            ->add('save', SubmitType::class, [
                'label' => 'enregistrer'
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
