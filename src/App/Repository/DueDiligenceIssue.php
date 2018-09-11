<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/10/18
 * Time: 3:06 PM
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class DueDiligenceIssue extends EntityRepository
{
    public function updateIssueStatus(int $status, int  $id)
    {
        $sql = "UPDATE DueDiligenceIssue SET status_id = $status WHERE id = $id";
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $result = $stmt->execute();
        if ($result)
            return true;
        else
            return false;
    }
}