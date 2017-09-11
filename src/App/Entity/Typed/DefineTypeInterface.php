<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 6/22/16
 * Time: 1:14 PM
 */

namespace App\Entity\Typed;


interface DefineTypeInterface
{
    public function getId ();

    function getLabel();

    function getSlug();

    function setLabel($label);

    function setSlug($label);

}