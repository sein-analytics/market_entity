<?php
namespace App\Entity\AssetType;

use App\Entity\Loan;
use App\Entity\Loan\ArmAttribute;
class Auto extends Loan
{

    /**
     * @return ArmAttribute|null
     */
    public function getArmAttributes():?ArmAttribute
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

    public function setAssetAttributes(array $assetAttributes)
    {
        $string = json_encode($assetAttributes);
        $this->implementChange($this,'assetAttributes', $this->assetAttributes, $string);
    }


    public function getAssetAttributes()
    {
        if (is_string($this->assetAttributes)){
            return json_decode($this->assetAttributes, true);
        }
        return $this->assetAttributes;
    }
}