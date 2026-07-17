<?php

namespace App\Repository\Loan;

use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class PropertyAttribute extends EntityRepository
    implements SqlManagerTraitInterface, DbalStatementInterface, LoanInterface
{
    use FetchingTrait, FetchMapperTrait, QueryManagerTrait;

    static array $table = [
        'id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::PROPERTY_CATEGORY],
        'loan_id' => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL', self::PROP_CATEGORY_KEY =>self::PROPERTY_CATEGORY],
        'address' => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PROPERTY_CATEGORY],
        'report_links' => [self::DATA_TYPE => 'array', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PROPERTY_CATEGORY],
        'price_comps' => [self::DATA_TYPE => 'array', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PROPERTY_CATEGORY],
        'property_pictures' => [self::DATA_TYPE => 'array', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PROPERTY_CATEGORY],
        'property_links' => [self::DATA_TYPE => 'array', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PROPERTY_CATEGORY],
        'seller_as_is_value' => [self::DATA_TYPE => 'float', self::DATA_DEFAULT => 'NULL', self::PROP_CATEGORY_KEY =>self::PROPERTY_CATEGORY],
    ];

    private $fetchAttributesByDealIdSql = "SELECT pAttr.* FROM PropertyAttribute AS pAttr INNER JOIN loans AS l ON l.id = pAttr.loan_id INNER JOIN Pool AS p ON p.id = l.pool_id WHERE p.deal_id=?";

    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
    }

    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('PropertyAttribute');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }

    public function fetchAttributesByDealId(int $dealId)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(),
            $this->fetchAttributesByDealIdSql,
            self::FETCH_ALL_ASSO_MTHD,
            [$dealId]
        );
    }

}