<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/7/17
 * Time: 6:41 PM
 */

namespace App\Service;


use Doctrine\ORM\EntityManager;

trait CreatePropertiesArrayTrait
{
    protected $id_text = '_id';

    /**
     * @return array
     */
    public function createEntityPropertiesArray()
    {
        $propData = [];
        $properties = get_class_vars(get_class($this));
        foreach ($properties as $propName => $property){
            $propData[] = $property;
            if(array_key_exists($propName, $this->ignoreDbProperties)){
                continue;
            }
            if(array_key_exists($propName, $this->defaultValueProperties)){
                $property = $this->defaultValueProperties[$propName];
            }
            if(array_key_exists($propName, $this->addUcIdToPropName)){
                $propName = $this->camelCaseToUs($propName) . '_id';
            }else{
                $propName = $this->camelCaseToUs($propName);
            }
            $propData[$propName] = $property;
        }
        return $propData;
    }

    /**
     * @param string $input
     * @return string
     */
    public function camelCaseToUs(string $input)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z])(?![a-z]))*/', '_$0', $input)), '_');
    }
}