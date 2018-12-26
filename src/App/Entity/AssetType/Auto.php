<?php
namespace App\Entity\AssetType;

use App\Entity\Loan;
class Auto extends Loan
{

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

    public function setAssetAttributes(array $assetAttributes)
    {
        $string = json_encode($assetAttributes);
        $this->_onPropertyChanged('assetAttributes', $this->assetAttributes, $string);
        $this->assetAttributes = $string;
    }


    public function getAssetAttributes()
    {
        if (is_string($this->assetAttributes)){
            return json_decode($this->assetAttributes, true);
        }
        return $this->assetAttributes;
    }
}