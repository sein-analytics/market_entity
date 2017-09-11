<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/22/16
 * Time: 1:21 PM
 */

namespace App\Entity\Typed\Update;


use App\Entity\Period;

interface TypedUpdateInterface
{
    public function getId();

    public function getIsHistory();

    /**
     * @return Period $period
     */
    public function getPeriod();

    /**
     * @param Period $period
     */
    public function setPeriod(Period $period);

}