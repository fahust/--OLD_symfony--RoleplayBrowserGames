<?php

namespace App\Form;

use App\Entity\UserSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ascusername', SubmitType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'User par ascendant'
                ]
            ])
            ->add('descusername', SubmitType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'User par descendant'
                ]
            ])
            /*->add('submit',SubmitType::class, [
                'label' => 'rechercher'
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserSearch::class,
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
