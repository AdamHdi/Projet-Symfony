<?php

namespace App\Service;

use App\Entity\Commande;

class TarifGenerator
{

    public function dateDifference($date, $birthDate, $differenceFormat = '%y')
    {
        
        $interval = date_diff($date, $birthDate);
        
        return $interval = $interval->format($differenceFormat);
        
    }

    public function getTarif(Commande $commande)
    {
        $tarif = 0;
        foreach ($commande->getBillets() as $billet) {
            $interval = $this->dateDifference($commande->getDate(), $billet->getBirthDate());
            if(($interval > 12) && ($interval < 65)) {
                if ($billet->getType() === 'reduit') {
                    $billet->setPrice(10);
                } else {
                    $billet->setPrice(16);
                }
            } elseif ($interval > 65) {
                $billet->setPrice(12);
            } elseif (($interval < 12) && ($interval > 4)) {
                $billet->setPrice(8);
            } else {
                $billet->setPrice(0);
            }
            $tarif = $tarif + $billet->getPrice();
        }
        return $tarif;
    }

}