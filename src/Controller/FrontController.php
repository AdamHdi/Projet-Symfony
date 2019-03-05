<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
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
                     ->add('type')
                     ->add('date')
                     ->add('fullday')
                     ->add('name')
                     ->add('country')
                     ->add('birthDate')
                     ->getForm();

        return $this->render('front/reservation.html.twig', [
            'formBillet' => $form->createView()
        ]);
    }
}

