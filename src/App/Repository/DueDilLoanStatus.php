<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/10/18
 * Time: 3:12 PM
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class DueDilLoanStatus extends EntityRepository
{
    public function fetchLoanIdsByDdId(int $ddId)
    {
        $sql = 'SELECT ln_id AS id, loan_id, ddStat.status_id, dd_id, user_id, dd_role_id, first_name, last_name, status FROM DueDilLoanStatus ddStat ' .
            'LEFT JOIN loans ln ON ln.id = ddStat.ln_id ' .
            'LEFT JOIN DueDiligence dd ON dd.id=dd_id ' .
            'LEFT JOIN MarketUser users ON users.id=user_id ' .
            'LEFT JOIN DueDilReviewStatus revStat on revStat.id=ddStat.status_id ' .
            'WHERE dd_id = ? ORDER BY id ASC';
        $stmt= $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $ddId);
        $stmt->execute();
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        $stmt->closeCursor();
        return $results;
    }
}