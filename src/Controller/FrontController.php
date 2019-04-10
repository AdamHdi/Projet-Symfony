<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Commande;
use App\Form\BilletType;
use App\Form\CommandeType;
use App\Service\TarifGenerator;

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
     * @Route("/payment/{id}", name="payment")
     */
    public function new($id, TarifGenerator $tarifGenerator, ObjectManager $manager)
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);

        $commande = $repo->find($id);

        $tarif = $tarifGenerator->getTarif($commande);

        $commande->setPrice($tarif);

        $manager->persist($commande);
        $manager->flush();

        return $this->render('front/payment.html.twig', [
            'commande' => $commande
        ]);
    }

    /**
     * @Route("/success", name="success")
     */
    public function booking_success(Request $request)
    {
        $stripe = $stripe->handleRequest($request);

        

        return $this->render('front/success.html.twig');
    }

    /**
     * @Route("/reservation", name="reservation")
     */
    public function booking(Request $request, ObjectManager $manager)
    {
        $commande = new Commande();

        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            foreach ($commande->getBillets() as $billet) {
                $billet->setCommande($commande);
            }

            $manager->persist($commande);
            $manager->flush();

            return $this->redirectToRoute('payment', ['id' => $commande->getId()]);
        }

        return $this->render('front/reservation.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

