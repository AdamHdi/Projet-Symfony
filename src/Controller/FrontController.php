<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    /**
     * @Route("/front", name="front")
     */
    public function index()
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('front/home.html.twig');
    }

    /**
     * @Route("/reservation", name="reservation")
     */
    public function booking(Request $request, ObjectManager $manager)
    {
        $billet = new Billet();

        $form = $this->createFormBuilder($billet)
                     ->add('type', ChoiceType::class, [
                        'choices'  => [
                            'Tarif normal' => 'normal',
                            'Tarif enfant' => 'enfant',
                            'Tarif senior' => 'senior',
                            'Tarif reduit' => 'reduit',
                        ],
                     ])
                     ->add('date')
                     ->add('fullday', ChoiceType::class, [
                        'choices' => [
                            'Journée complète' => true,
                            'Demi-jounrée' => false,
                        ],
                        'expanded' => true,
                     ])
                     ->add('name')
                     ->add('country', CountryType::class)
                     ->add('birthDate')
                     ->getForm();

        return $this->render('front/reservation.html.twig', [
            'formBillet' => $form->createView()
        ]);
    }
}

