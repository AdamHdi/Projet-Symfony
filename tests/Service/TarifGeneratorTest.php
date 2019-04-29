<?php

namespace Tests\App\Service;

use App\Service\TarifGenerator;
use App\Entity\Billet;
use App\Entity\Commande;
use PHPUnit\Framework\TestCase;

class TarifGeneratorTest extends TestCase
{

    public function testGetTarif()
    {
        $commande = new Commande();
        $dateCommande = new \DateTimeInterface('2020-01-01');
        $commande->setDate($dateCommande);

        $billet = new Billet();
        $birthDate = new \DateTimeInterface('1995-01-01');
        $billet->setBirthDate($birthDate);
        $billet->setType('normal');
        $billet->setCommande($commande);

        $commande->addBillet($billet);

        $this->assertSame(16, $this->getTarif($commande));
    }

}