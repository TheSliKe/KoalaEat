<?php

namespace App\Form;

use App\Entity\Restaurateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilRestaurateurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('RES_Nom')
            ->add('RES_Prenom')
            ->add('RES_Telephone')
            ->add('RES_Mail')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurateur::class,
        ]);
    }
}
