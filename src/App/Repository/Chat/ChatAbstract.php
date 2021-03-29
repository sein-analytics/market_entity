<?php


namespace App\Repository\Chat;


use App\Repository\DbalStatementInterface;
use App\Service\FetchingTrait;
use App\Service\FetchMapperTrait;
use Doctrine\ORM\EntityRepository;
use function Lambdish\phunctional\{each};

abstract class ChatAbstract extends EntityRepository
    implements DbalStatementInterface
{
    use FetchMapperTrait, FetchingTrait;

    const USER_UUID_FIELD = 'email_confirm_hash';

    const USER_ID_BY_UUID_SQL = 'SELECT id FROM MarketUser WHERE email_confirm_hash = ?';

    const GROUP_ID_BY_UUID_SQL = 'SELECT id FROM ChatGroup WHERE uuid = ?';

    /**
     * @param string $uuid
     * @param string $class
     * @param string $method
     * @return \Exception|mixed
     */
    public function validateMarketUserUuid(string $uuid, string $class, string $method)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(), self::USER_ID_BY_UUID_SQL, self::FETCH_ONE_MTHD, [$uuid]
        );
    }

    /**
     * @param string $uuid
     * @param string $class
     * @param string $method
     * @return \Exception|mixed
     */
    public function validateChatGroupUuid(string $uuid, string $class, string $method)
    {
        return $this->buildAndExecuteFromSql(
            $this->getEntityManager(), self::GROUP_ID_BY_UUID_SQL, self::FETCH_ONE_MTHD, [$uuid]
        );
    }

    protected function validateUuid(string $uuid, string $class, string $method)
    {
        $em = $this->getEntityManager();
        $validate = false;
        $user = $this->buildAndExecuteFromSql(
            $em, self::USER_ID_BY_UUID_SQL, self::FETCH_ONE_MTHD, [$uuid]
        );
        $group = $this->buildAndExecuteFromSql(
            $em, self::GROUP_ID_BY_UUID_SQL, self::FETCH_ONE_MTHD, [$uuid]
        );
        if (!$user && !$group)
            throw $this->getRepoException()::validUuidRequired($class, $method);
        return true;
    }

    protected function executeUuidValidation(string $uuid, string $class, string $method)
    {
        try {
           return $this->validateUuid($uuid, $class, $method);
        } catch (\Exception $exception){
            return $exception;
        }
    }

    protected function testInsertParams(array $params, string $tableName)
    {
        $cols = $this->getEntityManager()->getConnection()
            ->getSchemaManager()->listTableColumns($tableName);
        if (is_null($cols))
            return false;
        $valid = true;
        /** @var  \Doctrine\DBAL\Schema\Column */
        each(function ($schemaCol) use(&$valid, $params) {
            if (!array_key_exists($schemaCol->getName(), $params)) {
                $valid = false;
            }else {
                if ($schemaCol->getNotnull() && $params[$schemaCol->getName()]){
                    $valid = false;
                } elseif ($schemaCol->getType()->getName() !== gettype($params[$schemaCol->getName()])){
                    $valid = false;
                }
            }
            return $valid;
        }, $cols);
        return $valid;
    }
}