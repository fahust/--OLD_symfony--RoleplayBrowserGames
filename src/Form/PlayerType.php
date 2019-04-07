<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', HiddenType::class)
            ->add('level', HiddenType::class)
            ->add('experience', HiddenType::class)
            ->add('skillpnt', HiddenType::class)
            ->add('hp', HiddenType::class)
            ->add('atk', HiddenType::class)
            ->add('image', HiddenType::class)
            ->add('createdAt', HiddenType::class)
            ->add('skillbdd', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
