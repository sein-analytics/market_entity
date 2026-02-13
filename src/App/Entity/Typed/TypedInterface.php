<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/22/16
 * Time: 1:15 PM
 */

namespace App\Entity\Typed;


use Exception;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Deal;
use App\Entity\Typed\Update\TypedUpdateInterface;

interface TypedInterface
{

    /**
     * @return int
     */
    public function getId();

    /** @return Deal */
    function getDeal();

    /**  @param Deal $deal */
    function setDeal(Deal $deal);

    /** @return ArrayCollection $feesUpdate */
    function getUpdates();

    /**
     * @param TypedUpdateInterface $updateInterface
     * @throws Exception
     */
    function addUpdate(TypedUpdateInterface $updateInterface);

    /** @return TypedUpdateInterface */
    function getLatestUpdate();

    /**
     * @param TypedUpdateInterface $latestUpdate
     */
    public function setLatestUpdate(TypedUpdateInterface $latestUpdate);

    /** @return string $feeformula */
    function getFormula ();

    /** @param  string $formula */
    function setFormula($formula);

    /** @return DefineTypeInterface */
    function getType();

    /** @param DefineTypeInterface $type */
    function setType(DefineTypeInterface $type);

}