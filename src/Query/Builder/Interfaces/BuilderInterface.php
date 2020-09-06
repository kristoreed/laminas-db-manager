<?php

namespace Kristoreed\Laminas\DbManager\Query\Builder\Interfaces;

use Kristoreed\Laminas\DbManager\Query\Builder\Exceptions\BuilderException;
use Laminas\Db\Adapter\Driver\StatementInterface;

/**
 * Interface BuilderInterface
 *
 * @package Kristoreed\Laminas\DbManager\Query\Builder\Interfaces
 * @author Krzysztof Trzcinka
 */
interface BuilderInterface
{
    /**
     * @param string $querySource
     * @param array $parameters
     *
     * @return StatementInterface
     *
     * @throws BuilderException
     */
    public function create(string $querySource, array $parameters = []): StatementInterface;
}
