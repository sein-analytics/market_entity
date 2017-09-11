<?php
namespace App\Entity\AssetType;

use App\Entity\Loan;
class Auto extends Loan
{



    protected $assetAttributes = array();

    /**
     * @return Loan\ArmAttribute
     */
    public function getArmAttributes()
    {
        return $this->armAttributes;
    }

    /**
     * @param Loan\ArmAttribute $armAttributes
     */
    public function setArmAttributes(Loan\ArmAttribute $armAttributes)
    {
        $this->armAttributes = $armAttributes;
    }


    public function getAssetAttributes()
    {
        $attributes = serialize($this->assetAttributes);
        return $attributes;
    }
}