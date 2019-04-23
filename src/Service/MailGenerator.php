<?php

namespace App\Service;

use App\Entity\Commande;

class MailGenerator
{
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig; 
    }

    public function sendEmail(Commande $commande, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Email recapitulatif de commande'))
            ->setFrom('projectestmail@gmail.com')
            ->setTo($commande->getMail())
            ->setBody(
                $this->twig->render('front/mail.html.twig', [
                    'commande' => $commande
                ]),
                'text/html'
            )
        ;
    
        $mailer->send($message);
    }

}