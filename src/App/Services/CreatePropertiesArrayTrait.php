<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/7/17
 * Time: 6:41 PM
 */

namespace App\Service;


trait CreatePropertiesArrayTrait
{
    public function createEntityPropertiesArray()
    {
        $propData = [];
        $properties = get_class_vars(get_class($this));
        foreach ($properties as $propName => $property){
            $propData[] = $property;
        }
        return $propData;
    }
}