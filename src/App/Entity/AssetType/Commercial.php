<?php
namespace App\Entity\AssetType;

use App\Entity\Loan;
class Commercial extends Loan
{
    protected $assetAttributes;

    public function getAssetAttributes()
    {
        $attributes = serialize($this->assetAttributes);
        return $attributes;
    }

    public function setDscr($dscr)
    {
        $attr = $this->getAssetAttributes();
        $attr = @unserialize($attr);
        $attr['Dscr']   = $dscr;
        $this->assetAttributes = @serialize($attr);
    }
    
    public function getDscr()
    {
        $atr = $this->getAssetAttributes();
        $open = @unserialize($atr);
        if (array_key_exists('Dscr', $open)){
            return $open['Dscr'];
        }else{
            return false;
        }
    }
}