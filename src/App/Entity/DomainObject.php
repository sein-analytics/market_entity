<?php


namespace App\Entity;


use Doctrine\Persistence\NotifyPropertyChanged;
use Doctrine\Persistence\PropertyChangedListener;
use Illuminate\Database\Eloquent\Model;

abstract class DomainObject extends Model implements NotifyPropertyChanged
{
    private $listeners = [];

    public function __construct() { parent::__construct(); }

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

    protected function implementChange(DomainObject $classObject, $propName, $oldValue, $newValue) {
        if ($oldValue !== $this) {
            $this->_onPropertyChanged($propName, $oldValue, $newValue);
            $classObject->$propName = $newValue;
        }
    }
}