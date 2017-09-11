<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 */

namespace App\Entity\AssetType;

use App\Entity\Loan;
class CreditCard extends Loan
{

    protected $assetAttributes = array();

    public function getAssetAttributes()
    {
        $attributes = serialize($this->assetAttributes);
        return $attributes;
    }
}