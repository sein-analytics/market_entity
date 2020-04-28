<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 3/13/18
 * Time: 10:00 AM
 */

namespace App\Repository\Data;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class Swaps extends Rates
{
    public function fetchSwapRates()
    {
        return $this->fetchRates(self::SWAPS_KEY);
    }
}