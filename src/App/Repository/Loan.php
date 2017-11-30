<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/18/17
 * Time: 5:31 PM
 */

namespace App\Repository;

use App\Service\QueryManagerTrait;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class Loan extends EntityRepository implements SqlManagerTraitInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    private $subTypes = [
        'Auto' => '\AssetType\Auto',
        'Commercial' => '\AssetType\Commercial',
        'Cre' => '\AssetType\Cre',
        'CreditCard' => '\AssetType\CreditCard',
        'HomeEquity' => '\AssetType\HomeEquity',
        'Residential' => '\AssetType\Residential'
    ];


    /**
     * @param int $dealId
     * @return array|bool
     */
    public function fetchLoansByDealId(int $dealId)
    {
        $em = $this->getEntityManager();
        $sql = "SELECT * FROM Pool WHERE deal_id IN (?)";
        $results = $this->fetchByIntArray($em, array($dealId), $sql);
        if(count($results) > 0){
            $results = $this->fetchLoansByPoolIds(array($results[0]['id']));
        }
        return $results;
    }

    /**
     * @param array $ids
     * @return array|bool
     */
    public function fetchLoansByPoolIds(array $ids)
    {
        $sql = "SELECT loans.*, ArmAttribute.gross_margin, ArmAttribute.minimum_rate, ArmAttribute.maximum_rate, ArmAttribute.rate_index, ".
            "ArmAttribute.fst_rate_adj_period, ArmAttribute.fst_rate_adj_date, ArmAttribute.fst_pmnt_adj_period, ArmAttribute.fst_pmnt_adj_date, ArmAttribute.rate_adj_frequency, ".
            " ArmAttribute.periodic_cap, ArmAttribute.initial_cap, ArmAttribute.pmnt_adj_frequency, ArmAttribute.pmnt_increase_cap ".
            "FROM loans INNER JOIN ArmAttribute ON ArmAttribute.loan_id = loans.id WHERE loans.pool_id IN (?) ORDER BY pool_id ASC ";
        $armLoans = $this->fetchByIntArray($this->getEntityManager(), $ids, $sql);
        $noArms = [];
        if(count($armLoans) > 0){
            $loansId = [];
            foreach ($armLoans as $loan){
                array_push($loansId, $loan['id']);
            }
            $sql = "SELECT * FROM loans WHERE pool_id IN (?) AND id NOT IN (?) ORDER BY id ASC ";
            $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql,
                array($ids, $loansId),
                array(\Doctrine\DBAL\Connection::PARAM_INT_ARRAY,
                    \Doctrine\DBAL\Connection::PARAM_INT_ARRAY)
            );
            $noArms = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        }
        $results = array_merge($noArms, $armLoans);
        return $results;
    }

    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('loans');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        if(is_null($subType) && !array_key_exists($subType, $this->subTypes)){
            return false;
        }

        $reflector = $this->entityReflectorFromEntityName('App\Entity' . $this->subTypes[$subType]);
        return $this->entityPropertiesFromReflector($reflector);
    }

}