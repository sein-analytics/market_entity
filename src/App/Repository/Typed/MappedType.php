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

class MappedType extends EntityRepository implements DbalStatementInterface
{
    use FetchingTrait;

    protected $mappedRepos = [
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
    ];

    /**
     * @return array
     */
    public function fetchAllMappedTypeData()
    {
        $result = [];
        foreach ($this->mappedRepos as $db => $propName) {
            $name =ucfirst($db);

            $result[$propName] = $this->buildAndExecuteFromSql(
                $this->getEntityManager(),
                "SELECT * FROM $name",
                self::FETCH_ALL_ASSO_MTHD
            );
        }
        return $result;
    }
}