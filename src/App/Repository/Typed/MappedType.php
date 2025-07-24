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

    private string $fetchArmIndexTypeSql = 'SELECT * FROM ArmIndexType';

    private string $fetchPurposeTypeSql = 'SELECT * FROM PurposeType';

    private string $fetchOccupancyTypeSql = 'SELECT * FROM OccupancyType';

    /*protected array $mappedRepos = [
        'armIndexType' => 'rateIndex',
        'purposeType' => 'purpose',
        'occupancyType' => 'occupancy',
        'statusType' => 'loanStatus',
        'loanType' => 'loanType',
        'propertyType' => 'dwelling',
        'documentationType' => 'documentation',
        'state' => 'state',
        'lienType' => 'lien',
        'newUsed'   => 'newUsed',
        'yearBuilt' => 'yearBuilt'
    ];*/

    /**
     * @return array
     */
    public function fetchAllMappedTypeData():array
    {
        $result = [];
        /*foreach ($this->mappedRepos as $db => $propName) {
            $result[$propName] = $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                "SELECT * FROM " . ucfirst($db),
                self::EXECUTE_MTHD
            );
        }*/
        /* $arr = $this->typePropsToTypeTables();
        return $arr; */
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

    /*private function typePropsToTypeTables():array
    {
        return [
            self::ARM_INDEX_TYPE_PROP => self::ARM_INDEX_TYPE_DB,
            self::PURPOSE_TYPE_PROP => self::PURPOSE_TYPE_DB,
            self::OCCUPANCY_TYPE_PROP => self::OCCUPANCY_TYPE_DB,
            self::STATUS_TYPE_PROP => self::STATUS_TYPE_DB,
        ];
    }*/
}