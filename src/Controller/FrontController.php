<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Commande;
use App\Form\BilletType;
use App\Form\CommandeType;

use App\Service\CheckDate;
use App\Service\MailGenerator;
use App\Service\TarifGenerator;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/success/{uuid}", name="success")
     */
    public function booking_success($uuid, MailGenerator $mailGenerator, Request $request, \Swift_Mailer $mailer)
    {
        $repo = $this->getDoctrine()->getRepository(Commande::class);

        $commande = $repo->findBy(['uuid' => $uuid]);

        $mailGenerator->sendEmail($commande[0], $mailer);

        return $this->render('front/success.html.twig', [
            'commande' => $commande[0]
        ]);
    }

    /**
     * @Route("/reservation", name="reservation")
     */
    public function booking(Request $request, ObjectManager $manager, CheckDate $checkDate)
    {
        $commande = new Commande();

        $form = $this->createForm(CommandeType::class, $commande);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            foreach ($commande->getBillets() as $billet) {
                $billet->setCommande($commande);
            }
            dump($request);

            $manager->persist($commande);
            $manager->flush();

            return $this->redirectToRoute('payment', ['id' => $commande->getId()]);
        }

        return $this->render('front/reservation.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/check-date/{date}", name="check-date")
     */
    public function checkDate($date, CheckDate $checkDate) 
    {
        $date = new \DateTime($date);

        $reponse = $checkDate->getResponse($date);
        
        // $repo = $this->getDoctrine()->getRepository(Commande::class);

        // $commandes = $repo->findBy(['date' => $date]);

        // $commandesNumber = sizeof($commandes);

        // return new JsonResponse(['quantity' => $commandesNumber]);

        return new JsonResponse(['quantity' => $reponse]);

        // faire service qui prend en param la date envoyé et refaire la meme chose que ici
        // puis appelé service dans commande et si return = 0 laissé une erreur
    }
}

