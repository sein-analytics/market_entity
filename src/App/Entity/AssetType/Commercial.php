<?php
namespace App\Entity\AssetType;

use App\Entity\Loan\ArmAttribute;
use App\Entity\Loan\CommAttribute;
use App\Entity\Loan;
class Commercial extends Loan
{
    public function setArmAttributes(ArmAttribute $armAttributes)
    {
        $this->implementChange($this,'armAttributes', $this->armAttributes, $armAttributes);
    }

    public function setCommAttributes(CommAttribute $commAttributes)
    {
        $this->implementChange($this,'commAttributes', $this->commAttributes, $commAttributes);
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