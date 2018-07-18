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
        $sql = 'SELECT ln_id AS id, loan_id, status_id, dd_id, user_id, dd_role_id FROM DueDilLoanStatus ' .
                'LEFT JOIN loans ln ON ln.id = DueDilLoanStatus.ln_id ' .
                'LEFT JOIN DueDiligence dd on dd.id=dd_id ' .
              'WHERE dd_id = ? ORDER BY id ASC';
        $stmt= $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindValue(1, $ddId);
        $stmt->execute();
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $results;
    }
}