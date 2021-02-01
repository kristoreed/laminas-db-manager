# laminas-db-manager

Laminas-db manager

## Installation

Use the package manager [composer](https://getcomposer.org/) to install laminas-db-manager.

```bash
composer require kristoreed/laminas-db-manager
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

# ------------ sql query object ---------------

$select = new Select();
$select->from(['u' => 'user'])
    ->columns(['*'])
    ->where(['id' => 404]);

$user = $queryExecutor->getRow($select);

# --------- sql query from file ---------------

$queryFileBuilder = new QueryFileBuilder($dbAdapter);
$queryFileBuilderResult = $queryFileBuilder->create('user.getUserById', [
    'id' => 404,
]);

$user = $queryExecutor->getRow($queryFileBuilderResult);

# --------- sql query from string -------------

$queryStringBuilder = new QueryStringBuilder($dbAdapter);
$queryStringBuilderResult = $queryStringBuilder->create('SELECT * FROM users AS u WHERE u.id=:id', [
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

// in above example getUserById is equivalent of getUserById.sql file and the file should be located inside project in directory: sql/storage/user/
```

## License
[MIT](https://choosealicense.com/licenses/mit/)
