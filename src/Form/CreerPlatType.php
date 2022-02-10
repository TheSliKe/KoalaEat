<?php

namespace App\Form;

use App\Entity\Plat;
use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreerPlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('PA_Libelle')
                ->add('PA_Prix')
                ->add('PA_Stock')
                ->add('FK_RE',
                    EntityType::class, 
                    array(
                        'class' => Restaurant::class,
                        'choices' => $options['restaurant']
                    )
                )
                ->add('estSupprime', 
                    HiddenType::class,
                    array(
                        'data' => 0
                    )
                );
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plat::class,
            'restaurant' => null
        ]);
    }
}