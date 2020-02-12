<?php


namespace App\Repository\Data;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class Treasuries extends Rates
{
    public function fetchTreasuryRates()
    {
        return $this->fetchRates('Treasuries');
    }
}