<?php

namespace App\Form;

use App\Entity\Plat;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class CreerPlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('PA_Libelle')
                ->add('PA_Prix')
                ->add('PA_Stock')
                ->add('FK_RE', EntityType::class, array(
                    'class' => Restaurant::class,
                    'choices' => $options['restaurant']
                ));
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plat::class,
            'restaurant' => null
        ]);
    }
}