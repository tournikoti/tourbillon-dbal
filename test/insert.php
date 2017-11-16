<?php

use Tourbillon\Dbal\ConnectionFactory;

require '../vendor/autoload.php';

$config = include './config/database.php';

$connectionFactory = new ConnectionFactory($config['database']);

$connection = $connectionFactory->getConnection('default');

$connection->insert('user', [
    'firstname' => "firstname",
    'lastname' => "lastname",
    'email' => "firstname.lastname@mail.test",
    'created_at' => date('Y-m-d H:i:s')
]);
