<?php

namespace App\Form;

use App\Entity\Livreur;
use App\Entity\Vehicule;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProfilLivreurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('LI_Nom')
            ->add('LI_Prenom')
            ->add('LI_Telephone',TelType::class)
            ->add('LI_Mail')
            ->add('FK_VI')
            ->add('vehicules', EntityType::class, [
                'class' => Vehicule::class,
                'multiple' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livreur::class,
        ]);
    }
}
