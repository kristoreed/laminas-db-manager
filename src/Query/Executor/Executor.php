<?php

namespace Kristoreed\Laminas\DbManager\Query\Executor;

use Kristoreed\Laminas\DbManager\Query\Executor\Exceptions\ExecutorException;
use Kristoreed\Laminas\DbManager\Query\Executor\Interfaces\ExecutorInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\ResultSet\AbstractResultSet;
use Laminas\Db\Adapter\Driver\StatementInterface;
use Laminas\Db\Sql\Delete;
use Laminas\Db\Sql\Insert;
use Laminas\Db\Sql\PreparableSqlInterface;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\Update;

/**
 * Class Executor
 *
 * @package Kristoreed\Laminas\DbManager\Query\Executor
 * @author Krzysztof Trzcinka <krzysztof.trzcinka@gmail.com>
 */
class Executor implements ExecutorInterface
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * Builder constructor
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @inheritdoc
     */
    public function getOne($sqlObject)
    {
        $row = $this->getRow($this->prepareStatement($sqlObject));
        if (empty($row)) {
            return false;
        }

        return $row[key($row)];
    }

    /**
     * @inheritdoc
     */
    public function getRow($sqlObject): array
    {
        $rows = $this->getRows($this->prepareStatement($sqlObject));
        if (empty($rows)) {
            return [];
        }

        return reset($rows);
    }

    /**
     * @inheritdoc
     */
    public function getRows($sqlObject): array
    {
        $result = $this->execute($this->prepareStatement($sqlObject));
        if (empty($result)) {
            return [];
        }

        return $result->toArray();
    }

    /**
     * @inheritdoc
     */
    public function insert(string $tableName, array $parameters)
    {
        $insert = new Insert();
        $insert->into($tableName)->values($parameters);

        $statement = $this->prepareStatement($insert);
        return $statement->execute()->getGeneratedValue();
    }

    /**
     * @inheritdoc
     */
    public function update(string $tableName, array $parameters, array $where): int
    {
        $update = new Update();
        $update->table($tableName)->set($parameters)->where($where);

        $statement = $this->prepareStatement($update);
        return $statement->execute()->count();
    }

    /**
     * @inheritdoc
     */
    public function delete(string $tableName, array $where): int
    {
        $delete = new Delete();
        $delete->from($tableName)->where($where);

        $statement = $this->prepareStatement($delete);
        return $statement->execute()->count();
    }

    /**
     * @inheritdoc
     */
    public function execute(StatementInterface $statement): AbstractResultSet
    {
        $resultSet = new ResultSet();
        return $resultSet->initialize($statement->execute());
    }

    /**
     * @param StatementInterface|PreparableSqlInterface $sqlObject
     *
     * @return StatementInterface
     *
     * @throws ExecutorException
     */
    private function prepareStatement($sqlObject): StatementInterface
    {
        if ($sqlObject instanceof StatementInterface) {
            return $sqlObject;
        }

        if ($sqlObject instanceof PreparableSqlInterface) {
            $sql = new Sql($this->adapter);
            return $sql->prepareStatementForSqlObject($sqlObject);
        }

        throw new ExecutorException(sprintf("Statement could not be case to StatementInterface"));
    }

    /**
     * @inheritdoc
     */
    public function beginTransaction(): void
    {
        $this->adapter->getDriver()->getConnection()->beginTransaction();
    }

    /**
     * @inheritdoc
     */
    public function commit(): void
    {
        $this->adapter->getDriver()->getConnection()->commit();
    }

    /**
     * @inheritdoc
     */
    public function rollback(): void
    {
        $this->adapter->getDriver()->getConnection()->rollback();
    }
}