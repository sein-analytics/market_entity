<?php
namespace App\Entity\AssetType;

use App\Entity\Loan;
class Commercial extends Loan
{
    public function setArmAttributes(Loan\ArmAttribute $armAttributes)
    {
        $this->_onPropertyChanged('armAttributes', $this->armAttributes, $armAttributes);
        $this->armAttributes =  $armAttributes;
    }

    public function setCommAttributes(Loan\CommAttribute $commAttributes)
    {
        $this->_onPropertyChanged('commAttributes', $this->commAttributes, $commAttributes);
        $this->commAttributes = $commAttributes;
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