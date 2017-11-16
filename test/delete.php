<?php

use Tourbillon\Dbal\ConnectionFactory;

require '../vendor/autoload.php';

$config = include './config/database.php';

$connectionFactory = new ConnectionFactory($config['database']);

$connection = $connectionFactory->getConnection('default');

$connection->delete('user', [
    'id' => 1
]);
