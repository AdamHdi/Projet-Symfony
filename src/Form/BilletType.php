<?php

namespace App\Form;

use App\Entity\Billet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class BilletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type', ChoiceType::class, [
            'choices'  => [
                'Tarif normal' => 'normal',
                'Tarif enfant' => 'enfant',
                'Tarif senior' => 'senior',
                'Tarif reduit' => 'reduit',
            ],
         ])
            ->add('fullday', ChoiceType::class, [
                'choices' => [
                    'Journée complète' => true,
                    'Demi-jounrée' => false,
                ],
                'expanded' => true,
             ])
            ->add('name')
            ->add('country', CountryType::class)
            ->add('birthDate', BirthdayType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Billet::class,
        ]);
    }
}
