<?php

use Tourbillon\Dbal\ConnectionFactory;

require '../vendor/autoload.php';

$config = include './config/database.php';

$connectionFactory = new ConnectionFactory($config['database']);

$connection = $connectionFactory->getConnection('default');

$connection->update('user', [
    'email' => "firstname.lastname.updated@mail.test",
], [
    'id' => 1
]);
