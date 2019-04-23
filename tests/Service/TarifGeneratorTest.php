<?php

namespace Tests\App\Service;

use PHPUnit\Framework\TestCase;
use App\Entity\Commande;

class TarifGeneratorTest extends TestCase
{

    public function testGetTarif()
    {
        $commande = new Commande();

        $billetData = ['id' => 1, 'type' => 'normal', 'fullday' => 1, 'name' => 'name', 'country' => 'AF', 'birthdate' => '1995-01-01'];
    }

}