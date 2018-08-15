<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 7/9/18
 * Time: 3:00 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class DueDiligence extends EntityRepository
{
    use FetchMapperTrait, FetchingTrait;

    /**
     * @param array $userIds
     * @param array $dealIds
     * @param array $exceptIds
     * @return array
     */
    public function fetchDdIdsByUserIdsDealIds(array $userIds, array $dealIds, array $exceptIds=[0])
    {
        $sql = 'SELECT id FROM DueDiligence WHERE `user_id` IN (?) AND deal_id IN (?) AND id NOT IN (?)';
        $stmt = $this->returnMultiIntArraySqlStmt($this->getEntityManager(), $sql, $userIds, $dealIds, $exceptIds);
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
        $sql = 'SELECT loan_id, deal_file_id, doc_type_id, deal_id, file_name AS fileName, file.user_id, image_arn AS link, ' .
            'issue AS dealName FROM deal_file_due_diligence ' .
            'LEFT JOIN DealFile file ON file.id = deal_file_due_diligence.deal_file_id ' .
            'LEFT JOIN MarketUser user ON user.id = file.user_id ' .
            'LEFT JOIN Deal deal ON deal.id=deal_id ' .
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
        $sql = 'SELECT DueDiligenceIssue.id AS issueId, due_diligence_id, status_id, file_id, file_name AS fileName, open_date AS created, ' .
            'closed_date, doc_type_id, type AS section, issue, status, priority_id, file.loan_id, message_priority AS significance FROM DueDiligenceIssue ' .
            'LEFT JOIN DealFile file ON file.id=file_id ' .
            'LEFT JOIN DocType doc on doc.id=doc_type_id ' .
            'LEFT JOIN DueDilIssueStatus ddstatus on ddstatus.id=status_id ' .
            'LEFT JOIN MessagePriority priority on priority.id=priority_id ' .
            'WHERE due_diligence_id IN (?) ORDER BY issueId, due_diligence_id ASC';
        $stmt = $this->returnMultiIntArraySqlStmt($this->getEntityManager(), $sql, $ddIds);
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $results;
    }

    /**
     * @param array $issueIds
     * @param array $loanIds
     * @return array
     */
    public function fetchMsgIssuesDataByIssueIdsLoanIds(array $issueIds, array $loanIds)
    {
        $sql = 'SELECT Message.id AS msg_id, loan_id, user_id, issue_id, type_id, Message.status_id, priority_id, date AS dated, subject, message, ' .
            'first_name, last_name, image_arn AS senderPicture, issuer_id, issuer_name As senderCompany, message_status AS status, type FROM Message ' .
            'LEFT JOIN MarketUser user On user.id=user_id ' .
            'LEFT JOIN Issuer issuer ON issuer.id=issuer_id ' .
            'LEFT JOIN MessageStatus msg ON msg.id=Message.status_id ' .
            'LEFT JOIN MessageType msgType on msgType.id=type_id ' .
            'WHERE issue_id IN (?) AND loan_id IN (?)';
        $stmt = $this->returnMultiIntArraySqlStmt($this->getEntityManager(), $sql, $issueIds, $loanIds);
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $results;
    }

    /**
     * @param array $ddIds
     * @param $loanIds
     * @return array
     */
    public function fetchDdLoanStatusByDdIdLoanId(array $ddIds, $loanIds)
    {
        $sql = 'SELECT * FROM DueDilLoanStatus WHERE dd_id IN (?) AND ln_id IN (?)';
        $stmt = $this->returnMultiIntArraySqlStmt($this->getEntityManager(), $sql, $ddIds, $loanIds);
        $results = $stmt->fetchAll(Query::HYDRATE_ARRAY);
        return $results;
    }

    public function fetchDdLeadUserIdByIssueIdDealId(int $issuerId, int $dealId)
    {
        $sql = 'SELECT user_id FROM DueDiligence dd ' .
            'LEFT JOIN MarketUser users on users.id=user_id ' .
            'WHERE issuer_id = ? AND dd.dd_role_id=1 AND dd.deal_id=?';
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->bindParam(1, $issuerId);
        $stmt->bindParam(2, $dealId);
        $stmt->execute();
        $result = $stmt->fetch(Query::HYDRATE_ARRAY);
        if(array_key_exists('user_id', $result)){
            return (int)$result['user_id'];
        }
        return $result;
    }
}