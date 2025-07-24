<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/6/17
 * Time: 2:02 PM
 */

namespace App\Repository\Typed;

use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use Doctrine\ORM\EntityRepository;

class MappedType extends EntityRepository
    implements DbalStatementInterface, MappedTypeInterface
{
    use FetchingTrait;


    /**
     * @return array
     */
    public function fetchAllMappedTypeData():array
    {
        $result = [];
        foreach (self::PROP_TO_TABLE_MAP as $prop => $propTable){
            $sql = "SELECT * FROM $propTable";
            $result[$prop]['sql'] = $sql;
            $result[$prop][] = $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                $sql,
                self::FETCH_ALL_ASSO_MTHD
            );
        }
        return $result;
    }

}