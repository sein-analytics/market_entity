<?php
namespace App\Repository\DueDiligence;
use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use function Lambdish\phunctional\{each};

abstract class DueDiligenceAbstract extends EntityRepository
    implements DbalStatementInterface, IssueInterface, DueDiligenceInterface, DueDilLoanStatusInterface
{
    use FetchingTrait, FetchMapperTrait;

    protected static string $callUserSaleDealIdsInDueDiligence = 'call UserSaleDealIdsInDueDiligence(:userId)';

    protected static string $callDealFileDataByIssuerDueDiligenceIds = 'call DealFileDataByIssuerDueDiligenceIds(:issuerId)';

    protected static string $callIssuesDataByIssuerDueDiligenceIds = 'call IssuesDataByIssuerDueDiligenceIds(:issuerId)';

    protected static string $callIssuesMsgsDataByIssuerDueDiligenceIds = 'call IssuesMsgsDataByIssuerDueDiligenceIds(:issuerId)';

    protected static string $callDiligenceTeamFileOwner = 'call DiligenceTeamFileOwner(:dealId, :fileId, :dueDilParentId)';

    protected static string $callDueDilSellersLoanData = 'call DueDilSellersLoanData(:userIds)';

    protected static string $callDueDilBuyersLoanData = 'call DueDilBuyersLoanData(:userIds)';

    protected static string $callDueDilSellerBiddersData = 'call DueDilSellerBiddersData(:dealIds)';

    protected static string $userPurchaseDueDiligenceDealIdsSql = 'SELECT deal_id AS id FROM `DueDiligence` WHERE user_id = ?';

    protected static string $dueDilLoanStatusByDdIdsLoanIdsSql = 'SELECT * FROM DueDilLoanStatus WHERE dd_id IN (?) AND ln_id IN (?)';

    protected static string $dueDiligenceTeamDataSql = 'SELECT id AS userId, concat(first_name,\' \', last_name ) AS teamMemberName, role_id AS roleId, image_arn AS imageLink, user_name AS email FROM `MarketUser` WHERE issuer_id = ?';

    protected static string $buyingDealsFilterSql = "SELECT DISTINCT(user_id) AS dueDilUser, id as dueDilId, deal_id AS dealId, dd_role_id as userDdRole, parent_id as ddParent, bid_id as bidId FROM `DueDiligence` WHERE user_id IN (SELECT id FROM MarketUser WHERE issuer_id = ?)";

    protected static string $sellingDealsFilterSql = "SELECT DISTINCT (deal_id) AS dealId, user_id AS dueDilUser, DueDiligence.id as dueDilId, dd_role_id as userDdRole, parent_id as ddParent, bid_id as bidId, userDb.issuer_id AS ddUserIssuerId FROM `DueDiligence` " .
                                                    "LEFT JOIN MarketUser userDb on userDb.id = user_id " .
                                                    "WHERE deal_id IN ( SELECT id FROM Deal WHERE issuer_id = ? )";

    /*public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }*/
}