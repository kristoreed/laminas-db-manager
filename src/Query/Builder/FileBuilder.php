<?php

namespace Kristoreed\Laminas\DbManager\Query\Builder;

use Kristoreed\Laminas\DbManager\Query\Builder\Exceptions\BuilderException;

/**
 * Class FileBuilder
 *
 * @package Kristoreed\Laminas\DbManager\Query\Builder
 * @author Krzysztof Trzcinka <krzysztof.trzcinka@gmail.com>
 */
class FileBuilder extends Builder
{
    /**
     * @var array
     */
    private $rootPath = ['src', 'Queries'];

    /**
     * @param $rootPath
     *
     * @return $this
     */
    public function setRootPath(array $rootPath) : FileBuilder
    {
        $this->rootPath = $rootPath;
        return $this;
    }

    /**
     * @return array
     */
    public function getRootPath() : array
    {
        return $this->rootPath;
    }

    /**
     * @return string
     */
    private function prepareRootPath() : string
    {
        return getcwd() . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $this->rootPath);
    }

    /**
     * @inheritdoc
     */
    protected function provideQuery(string $querySource): string
    {
        $fileFullPath = $this->prepareRootPath();

        $filePathElements = explode('.', $querySource);
        foreach ($filePathElements as $filePathElement) {
            $fileFullPath .= DIRECTORY_SEPARATOR . $filePathElement;
        }

        $fileFullPath .= ".sql";

        if (!file_exists($fileFullPath)) {
            throw new BuilderException(sprintf("File $fileFullPath not exists"));
        }

        $fileContent = file_get_contents($fileFullPath);
        if (empty($fileContent)) {
            throw new BuilderException(sprintf("File $fileFullPath is empty"));
        }

        return $fileContent;
    }
}