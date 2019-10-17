<?php

namespace App\Form;

use App\Entity\Commande;
use App\Form\BilletType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Validator\Visitor;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mail')
            ->add('name', TextType::class, [
                'label'  => 'Nom',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'html5' => false,
                'attr' => [
                    'class' => 'js-datepicker',
                    ],
            ])
            ->add('billets', CollectionType::class, [
                'entry_type' => BilletType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => ['label' => 'Billet']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Passer la commande',
                'attr' => [ 'class' => 'btn btn-dark' ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
            'cascade_validation' => true,
        ]);
    }
}
