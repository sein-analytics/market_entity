<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/28/16
 * Time: 7:55 AM
 */

namespace App\Entity;
use Doctrine\Common\PropertyChangedListener;

/**
 * @deprecated
 */
trait NotifyChangeTrait
{
    private $_listener=[];

    public function addPropertyChangedListenerDep(PropertyChangedListener $listener)
    {
        $this->_listener[] = $listener;
    }


    public function _onPropertyChangedDep($propName, $oldValue, $newValue)
    {
        if ($this->_listener){
            foreach ($this->_listener as $listener){
                /** @var $listener \Doctrine\Common\PropertyChangedListener */
                $listener->propertyChanged($this, $propName, $oldValue, $newValue);
            }
        }
    }
    
}