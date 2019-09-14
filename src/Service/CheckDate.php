<?php

namespace App\Service;

use App\Entity\Commande;
use Doctrine\Common\Persistence\ManagerRegistry;

class CheckDate
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }



    public function getResponse($date)
    {
        $repo = $this->doctrine->getRepository(Commande::class);

        $commandes = $repo->findBy(['date' => $date]);

        $commandesNumber = sizeof($commandes);

        return $commandesNumber;
    }

}