<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/30/17
 * Time: 12:27 PM
 */

namespace App\Service;


interface SqlManagerTraitInterface
{
    /**
     * @return bool|mixed
     */
    function fetchNextAvailableId();

    /**
     * @param string|null $subType
     * @return bool|mixed
     */
    function fetchEntityPropertiesForSql(string $subType = null);
}