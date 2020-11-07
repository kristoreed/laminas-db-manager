<?php

namespace Kristoreed\Laminas\DbManager\Query\Executor\Interfaces;

use Kristoreed\Laminas\DbManager\Query\Executor\Exceptions\ExecutorException;
use Laminas\Db\Adapter\Driver\StatementInterface;
use Laminas\Db\ResultSet\AbstractResultSet;
use Laminas\Db\Sql\PreparableSqlInterface;

/**
 * Interface ExecutorInterface
 *
 * @package Kristoreed\Laminas\DbManager\Query\Executor\Interfaces
 * @author Krzysztof Trzcinka <krzysztof.trzcinka@gmail.com>
 */
interface ExecutorInterface
{
    /**
     * @param StatementInterface|PreparableSqlInterface $sqlObject
     *
     * @return bool|mixed
     *
     * @throws ExecutorException
     */
    public function getOne($sqlObject);

    /**
     * @param StatementInterface|PreparableSqlInterface $sqlObject
     *
     * @return array
     *
     * @throws ExecutorException
     */
    public function getRow($sqlObject): array;

    /**
     * @param StatementInterface|PreparableSqlInterface $sqlObject
     *
     * @return array
     *
     * @throws ExecutorException
     */
    public function getRows($sqlObject): array;

    /**
     * @param string $tableName
     * @param array $parameters
     *
     * @return mixed
     *
     * @throws ExecutorException
     */
    public function insert(string $tableName, array $parameters);

    /**
     * @param string $tableName
     * @param array $parameters
     * @param array $where
     *
     * @return int
     *
     * @throws ExecutorException
     */
    public function update(string $tableName, array $parameters, array $where): int;

    /**
     * @param string $tableName
     * @param array $where
     *
     * @return int
     *
     * @throws ExecutorException
     */
    public function delete(string $tableName, array $where): int;

    /**
     * @param StatementInterface $statement
     *
     * @return AbstractResultSet
     */
    public function execute(StatementInterface $statement): AbstractResultSet;

    /**
     * Begin transaction
     */
    public function beginTransaction(): void;

    /**
     * Commit transaction
     */
    public function commit(): void;

    /**
     * Rollback transaction
     */
    public function rollback(): void;
}
