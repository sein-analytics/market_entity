<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/9/18
 * Time: 3:00 PM
 */

namespace App\Repository;


use App\Service\FetchMapperTrait;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class DueDiligence extends EntityRepository
{
    use FetchMapperTrait;

    /**
     * @param array $userIds
     * @param array $dealIds
     * @param array $exceptIds
     * @return array
     */
    public function fetchDdIdsByUserIdsDealIds(array $userIds, array $dealIds, array $exceptIds=[0])
    {
        $sql = 'SELECT id FROM DueDiligence WHERE `user_id` IN (?) AND deal_id IN (?) AND id NOT IN (?)';
        $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql,
            array($userIds, $dealIds, $exceptIds),
            array(Connection::PARAM_INT_ARRAY,
                Connection::PARAM_INT_ARRAY)
        );
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        if(count($results)){
            return $this->flattenResultArrayByKey($results, 'id');
        }
        return $results;
    }

    /**
     * @param array $ddIds
     * @return array
     */
    public function fetchDealFileDataByDdIds(array $ddIds)
    {
        $sql = 'SELECT loan_id, deal_file_id, doc_type_id, file_name FROM deal_file_due_diligence ' .
            'LEFT JOIN `DealFile` file on file.id = deal_file_due_diligence.deal_file_id' .
            'WHERE due_diligence_id IN (?) ORDER BY loan_id, doc_type_id ASC';
        $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql,
            array($ddIds),
            array(Connection::PARAM_INT_ARRAY)
        );
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $results;
    }

    /**
     * @param array $ddIds
     * @return array
     */
    public function fetchDdIssuesDataByDdIds(array  $ddIds)
    {
        $sql = 'SELECT id, due_diligence_id, status_id, file_id, open_date, closed_date FROM DueDiligenceIssue ' .
            'WHERE due_diligence_id IN (?) ORDER BY id, due_diligence_id ASC';
        $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql,
            array($ddIds),
            array(Connection::PARAM_INT_ARRAY)
        );
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $results;
    }

    public function fetchMsgIssuesDataByIssueIdsLoanIds(array $issueIds, array $loanIds)
    {
        $sql = 'SELECT id as msg_id, loan_id, issue_id, type_id, status_id, priority_id, date, subject, message FROM Message ' .
            'WHERE issue_id IN (?) AND loan_id IN (?)';
        $stmt = $this->getEntityManager()->getConnection()->executeQuery($sql,
            array($issueIds, $loanIds),
            array(Connection::PARAM_INT_ARRAY, Connection::PARAM_INT_ARRAY)
        );
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $results;
    }
}