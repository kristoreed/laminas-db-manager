<?php

namespace Kristoreed\Laminas\DbManager\Query\Builder;

use Kristoreed\Laminas\DbManager\Query\Builder\Exceptions\BuilderException;
use Kristoreed\Laminas\DbManager\Query\Builder\Interfaces\BuilderInterface;
use Laminas\Db\Adapter\Driver\StatementInterface;
use Laminas\Db\Adapter\Adapter;

/**
 * Class BaseBuilder
 *
 * @package Kristoreed\Laminas\DbManager\Query\Builder
 * @author Krzysztof Trzcinka
 */
abstract class Builder implements BuilderInterface
{
    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * Builder constructor
     *
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @inheritdoc
     */
    public function create(string $querySource, array $parameters = []): StatementInterface
    {
        $query = $this->provideQuery($querySource);
        if (empty($parameters)) {
            return $this->adapter->query($query);
        }

        foreach ($parameters as $key => $parameter) {
            if (preg_match('/:.+/', ":$key", $matches)) {
                $query = preg_replace("/:$key/", $parameter, $query);
            }
        }

        return $this->adapter->query($query);
    }

    /**
     * @param string $querySource
     *
     * @return string
     *
     * @throws BuilderException
     */
    abstract protected function provideQuery(string $querySource): string;
}