<?php
/**
 * Created by PhpStorm.
 * User: ac1189
 * Date: 10/18/17
 * Time: 2:16 PM
 */

namespace App\Repository;


use App\Repository\LoanTapeTemplate\TemplateInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use App\Service\QueryManagerTrait;
use App\Service\SqlManagerTraitInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class LoanTapeTemplate extends EntityRepository
implements DbalStatementInterface, SqlManagerTraitInterface, TemplateInterface
{
    use FetchMapperTrait, FetchingTrait, QueryManagerTrait;

    const CHECK_ID_SQL = 'SELECT COUNT(id) AS count FROM LoanTapeTemplate WHERE id=?';

    const UPDATE_TEMPLATE_SQL = 'Update LoanTapeTemplate set template=? WHERE id=?';

    const TEMPLATE_INS_BASE_SQL = 'INSERT INTO `LoanTapeTemplate` (`id`, `user_id`, `asset_id`, `template`, `template_name`) VALUES';

    const TPLT_ID_BY_USR_TNAME_SQL = 'SELECT `id` FROM LoanTapeTemplate WHERE `user_id`=? AND `template_name`=?';

    static $table = [
        self::TEMPLATE_DB_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::TEMPLATE_DB_USR_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NOT NULL'],
        self::TEMPLATE_DB_ASSET_ID_KEY => [self::DATA_TYPE => 'int', self::DATA_DEFAULT => 'NULL'],
        self::TEMPLATE_DB_KEY => [self::DATA_TYPE => 'longtext', self::DATA_DEFAULT => 'NOT NULL'],
        self::TEMPLATE_DB_NAME_KEY => [self::DATA_TYPE => 'varchar', self::DATA_DEFAULT => 'NOT NULL']
    ];

    public function __construct(EntityManager $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $this->em = $em;
    }

    /**
     * @param array $userId
     * @return array|bool
     */
    public function fetchUserLoanTemplates(array $userId)
    {
        $sql = "SELECT * FROM LoanTapeTemplate WHERE user_id in (?) ORDER BY id ASC";
        $results = $this->fetchByIntArray($this->em, $userId, $sql);
        return $results;
    }

    /**
     * @param int $id
     * @param array $template
     * @return \Doctrine\DBAL\Driver\Exception|\Exception|mixed|string
     */
    public function updateLoanTemplate (int $id, array $template)
    {
        if (($stmt = $this->buildStmtFromSql($this->em, self::CHECK_ID_SQL, [$id]))
            instanceof \Exception
        )
            return 'Error executing id check: ' . $stmt->getMessage();
        $result = $this->executeStatementFetchMethod($stmt, self::EXECUTE_STMT_MTHD);
        if (!is_array($result )
            ||!array_key_exists('count', $result))
            return "LoanTapeTemplate with $id does not exist";
        $stmt = $this->buildStmtFromSql($this->em, self::UPDATE_TEMPLATE_SQL,
            [json_encode($template), $id]);
        if ($stmt instanceof \Exception)
            return $stmt->getMessage();
        return $this->executeStatementFetchMethod($stmt, self::EXECUTE_STMT_MTHD);
    }

    /**
     * @param int $userId
     * @param string $templateName
     * @return \Doctrine\DBAL\Driver\Exception|\Exception|mixed|string
     */
    public function templateIdByUserAndTemplateName(int $userId, string $templateName)
    {
        $stmt = $this->buildStmtFromSql($this->em, self::TPLT_ID_BY_USR_TNAME_SQL,
            [$userId, $templateName]);
        if ($stmt instanceof \Exception)
            return $stmt->getMessage();
        $result = $this->executeStatementFetchMethod($stmt, self::FETCH_ASSO_MTHD);
        if (!is_array($result))
            return $result;
        return $result[self::TEMPLATE_DB_ID_KEY];
    }

    /**
     * @return bool|int
     */
    public function fetchNextAvailableId()
    {
        return $this->fetchNextAvailableTableId('LoanTapeTemplate');
    }

    public function fetchEntityPropertiesForSql(string $subType = null)
    {
        return array_keys(self::$table);
    }
}