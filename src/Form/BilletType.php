<?php

namespace App\Form;

use App\Entity\Billet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
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
                'Tarif normal' => false,
                'Tarif reduit' => true,
            ],
            'label'  => 'Type de billet',
         ])
            ->add('fullday', ChoiceType::class, [
                'label'  => 'Durée',
                'choices' => [
                    'Journée complète' => true,
                    'Demi-jounrée' => false,
                ],
                'expanded' => true,
             ])
            ->add('name', TextType::class, [
                'label'  => 'Nom',
            ])
            ->add('country', CountryType::class, [
                'label'  => 'Pays',
            ])
            ->add('birthDate', BirthdayType::class, [
                'label'  => 'Date de naissance',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Billet::class,
        ]);
    }
}
