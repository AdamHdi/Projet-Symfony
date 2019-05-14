<?php

namespace Tests\App\Service;

use App\Service\TarifGenerator;
use App\Entity\Billet;
use App\Entity\Commande;
use PHPUnit\Framework\TestCase;

class TarifGeneratorTest extends TestCase
{

    public function testGetTarifAdult()
    {
        $commande = new Commande();
        $dateCommande = new \DateTime('2020-01-01');
        $commande->setDate($dateCommande);

        $billet = new Billet();
        $birthDate = new \DateTime('1995-01-01');
        $billet->setBirthDate($birthDate);
        $billet->setType('normal');
        $billet->setCommande($commande);

        $commande->addBillet($billet);
        $tarif = new TarifGenerator();

        $this->assertSame(16, $tarif->getTarif($commande));
    }

    public function testGetTarifs()
    {
        $commande = new Commande();
        $dateCommande = new \DateTime('2020-01-01');
        $commande->setDate($dateCommande);

        $billet = new Billet();
        $birthDate = new \DateTime('2010-01-01');
        $billet->setBirthDate($birthDate);
        $billet->setType('enfant');
        $billet->setCommande($commande);

        $commande->addBillet($billet);

        $billet2 = new Billet();
        $birthDate2 = new \DateTime('1920-01-01');
        $billet->setBirthDate($birthDate2);
        $billet2->setType('senior');
        $billet2->setCommande($commande);

        $commande->addBillet($billet2);

        $tarif = new TarifGenerator();

        $this->assertSame(20, $tarif->getTarif($commande));
    }

}