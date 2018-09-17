<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/10/18
 * Time: 3:06 PM
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Illuminate\Support\Facades\Log;

class DueDiligenceIssue extends EntityRepository
{
    public function updateIssueStatus(int $status, int  $id)
    {
        $sql = "UPDATE DueDiligenceIssue SET status_id = $status WHERE id = $id";
        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        } catch (\Exception $e){
            return false;
        }
        $result = $stmt->execute();
        if ($result)
            return true;
        else
            return false;
    }

    public function fetchAllIssueIds()
    {
        $sql = "SELECT id FROM DueDiligenceIssue";
        try{
            $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        } catch (\Exception $exception){
            return false;
        }
        $result = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $result;
    }
}