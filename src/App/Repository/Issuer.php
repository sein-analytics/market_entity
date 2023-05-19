<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 11/30/17
 * Time: 2:14 PM
 */

namespace App\Repository;


use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

class Issuer extends EntityRepository
    implements SqlManagerTraitInterface, DbalStatementInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    protected static string $userIdsByIssuerIdSql = 'SELECT id FROM MarketUser WHERE issuer_id=?';
    
    static $table = [
      'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
      'issuer_name' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
      'approved_date' => [self::DATA_TYPE => 'datetime', self::DATA_DEFAULT => 'NOT NULL'],
      'equity' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
      'outstanding' => [self::DATA_TYPE => 'decimal', self::DATA_DEFAULT => 'NOT NULL'],
      'main_contact' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL'],
      'phone' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL']
    ];

    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
    }

    public function fetchAllIssuerUserIds(int $issuerId)
    {
        $result = $this->buildAndExecuteFromSql($this->getEntityManager(),
        self::$userIdsByIssuerIdSql, self::FETCH_ALL_ASSO_MTHD, [$issuerId]
        );
        if (!is_array($result))
            return $result;
        return $this->flattenResultArrayByKey($result, self::QUERY_JUST_ID);
    }

    /**
     * @param int $id
     * @return array
     */
    public function fetchIssuerDataForBidReportById(int $id)
    {
        $sql = "SELECT id, issuer_name, main_contact, phone FROM Issuer WHERE id = ?";
        $stmt = $this->em->getConnection()
            ->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $result = $stmt->fetch(Query::HYDRATE_ARRAY);
        return $result;
    }

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('Issuer');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        array_keys(self::$table);
    }
}