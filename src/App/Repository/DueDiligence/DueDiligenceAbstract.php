<?php
namespace App\Repository\DueDiligence;
use App\Repository\DbalStatementInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

abstract class DueDiligenceAbstract extends EntityRepository
    implements DbalStatementInterface
{
    protected static string $callUserSaleDealIdsInDueDiligence = 'call UserSaleDealIdsInDueDiligence(:userId)';

    protected static string $callDealFileDataByIssuerDueDiligenceIds = 'call DealFileDataByIssuerDueDiligenceIds(:issuerId)';

    protected static string $callIssuesDataByIssuerDueDiligenceIds = 'call IssuesDataByIssuerDueDiligenceIds(:issuerId)';

    protected static string $callIssuesMsgsDataByIssuerDueDiligenceIds = 'call IssuesMsgsDataByIssuerDueDiligenceIds(:issuerId)';

    protected static string $userPurchaseDueDiligenceDealIdsSql = 'SELECT deal_id AS id FROM `DueDiligence` WHERE user_id = ?';

    protected static string $dueDilLoanStatusByDdIdsLoanIdsSql = 'SELECT * FROM DueDilLoanStatus WHERE dd_id IN (?) AND ln_id IN (?)';

    protected static string $dueDiligenceTeamDataSql = 'SELECT id as userId, concat(first_name,\' \', last_name ), role_id as roleId, image_arn as imageLink FROM `MarketUser` WHERE issuer_id = ? AND id != ?';

    /*public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }*/
}