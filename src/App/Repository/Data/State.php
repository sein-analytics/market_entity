<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 12/5/17
 * Time: 10:23 AM
 */

namespace App\Repository\Data;

use App\Repository\DbalStatementInterface;
use Doctrine\ORM\EntityRepository;
use App\Service\FetchingTrait;

class State extends EntityRepository implements DbalStatementInterface
{
    use FetchingTrait;

    private string $fetchAllStatesSql = "SELECT * FROM State";

    public function fetchAllStates()
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchAllStatesSql,
            self::FETCH_ALL_ASSO_MTHD
        );
    }

    /**
     * @param array $states
     * @param string $stateText
     * @return int|bool
     */
    public function stateIdFromStatesArray(array $states, string $stateText){
        foreach ($states as $stateProps){
            if($stateText == $stateProps['abbreviation']
                || $stateText == $stateProps['name']){
                return $stateProps['id'];
            }
        }
        return false;
    }
}