<?php

namespace Tests\App\Service;

use App\Service\TarifGenerator;
use App\Entity\Billet;
use App\Entity\Commande;
use PHPUnit\Framework\TestCase;

class TarifGeneratorTest extends TestCase
{

    public function testGetTarifAdulte()
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

    public function testGetTarifReduit()
    {
        $commande = new Commande();
        $dateCommande = new \DateTime('2020-01-01');
        $commande->setDate($dateCommande);

        $billet = new Billet();
        $birthDate = new \DateTime('1995-01-01');
        $billet->setBirthDate($birthDate);
        $billet->setType('reduit');
        $billet->setCommande($commande);

        $commande->addBillet($billet);
        $tarif = new TarifGenerator();

        $this->assertSame(10, $tarif->getTarif($commande));
    }

    public function testGetTarifEnfant()
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
        $tarif = new TarifGenerator();

        $this->assertSame(8, $tarif->getTarif($commande));
    }

    public function testGetTarifSenior()
    {
        $commande = new Commande();
        $dateCommande = new \DateTime('2020-01-01');
        $commande->setDate($dateCommande);

        $billet = new Billet();
        $birthDate = new \DateTime('1950-01-01');
        $billet->setBirthDate($birthDate);
        $billet->setType('senior');
        $billet->setCommande($commande);

        $commande->addBillet($billet);
        $tarif = new TarifGenerator();

        $this->assertSame(12, $tarif->getTarif($commande));
    }
}