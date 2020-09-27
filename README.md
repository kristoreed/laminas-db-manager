# laminas-db-manager

Laminas-db manager

## Installation

Use the package manager [composer](https://getcomposer.org/) to install laminas-db-manager.

```bash
composer required laminas-db-manager
```

## Usage

```php
use Laminas\Db\Adapter\Adapter;
use Kristoreed\Laminas\DbManager\Query\Builder\FileBuilder as QueryFileBuilder;
use Kristoreed\Laminas\DbManager\Query\Builder\StringBuilder as QueryStringBuilder;
use Kristoreed\Laminas\DbManager\Query\Executor\Executor as QueryExecutor;

$dbAdapter = new Adapter([
    'driver'    => 'pdo',
    'dsn'       => 'mysql:dbname=test;host=localhost',
    'username'  => 'admin',
    'password'  => 'admin',
]);

$queryExecutor = new QueryExecutor($dbAdapter);

$queryFileBuilder = new QueryFileBuilder($dbAdapter);
$queryFileBuilderResult = $queryFileBuilder->create('user.getUserById', [
    'id' => 404,
]);

$user = $queryExecutor->getRow($queryFileBuilderResult);

# or 

$querStringBuilder = new QueryStringBuilder($dbAdapter);
$querStringBuilderResult = $querStringBuilder->create('SELECT * FROM users AS u WHERE u.id=:id', [
    'id' => 404,
]);

$user = $queryExecutor->getRow($querStringBuilderResult);

```

## Additional notes
Using QueryFileBuilder please remember there is default root path in current working directory where sql files are store: src/Queries.
You can change it by:
```php
$queryFileBuilder = new QueryFileBuilder($dbAdapter);
$queryFileBuilder->setRootPath(['slq', 'storage']);
$queryFileBuilderResult = $queryFileBuilder->create('user.getUserById', [
    'id' => 404,
]);

// in above example getUserById.sql file should be located in directory: sql\storage\user\
```

## License
[MIT](https://choosealicense.com/licenses/mit/)
