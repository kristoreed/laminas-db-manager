<?php

namespace Kristoreed\Laminas\DbManager\Query\Builder;

use Kristoreed\Laminas\DbManager\Query\Builder\Exceptions\BuilderException;

/**
 * Class StringBuilder
 *
 * @package Kristoreed\Laminas\DbManager\Query\Builder
 * @author Krzysztof Trzcinka
 */
class StringBuilder extends Builder
{
    /**
     * @inheritdoc
     */
    protected function provideQuery(string $querySource): string
    {
        if (empty($querySource)) {
            throw new BuilderException(sprintf("String with sql query is empty"));
        }

        return $querySource;
    }
}