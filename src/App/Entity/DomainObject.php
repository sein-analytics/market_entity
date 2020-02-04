<?php


namespace App\Entity;


use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\Persistence\PropertyChangedListener;

abstract class DomainObject implements NotifyPropertyChanged
{
    private $listeners = [];

    public function addPropertyChangedListener(PropertyChangedListener $listener)
    {
        $this->listeners = $listener;
    }

    protected function _onPropertyChanged($propName, $oldValue, $newValue) {
        if ($this->listeners){
            foreach ($this->listeners as $listener){
                $listener->propertyChanged($this, $propName, $oldValue, $newValue);
            }
        }
    }

    protected function implementChange($classObject, $propName, $oldValue, $newValue) {
        if ($oldValue !== $this) {
            $this->_onPropertyChanged($propName, $oldValue, $newValue);
            $classObject->$propName = $newValue;
        }
    }
}