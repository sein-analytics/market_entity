<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\AssetType;

use App\Entity\Loan;
class Cre extends Loan
{
    public function getAssetAttributes()
    {
        if (is_string($this->assetAttributes)){
            return json_decode($this->assetAttributes, true);
        }
        return $this->assetAttributes;
    }

    public function setAssetAttributes(array $assetAttributes)
    {
        $string = json_encode($assetAttributes);
        $this->_onPropertyChanged('assetAttributes', $this->assetAttributes, $string);
        $this->assetAttributes = $string;
    }
}