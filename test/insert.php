<?php

use Tourbillon\Configurator\ConfiguratorFactory;
use Tourbillon\Dbal\ConnectionFactory;

require '../vendor/autoload.php';

$configurator = ConfiguratorFactory::createInstance(realpath(__DIR__ . '/config/database.neon'));

$connectionFactory = new ConnectionFactory($configurator);

$connection = $connectionFactory->getConnection('default');

$connection->insert('user', [
    'firstname' => "firstname",
    'lastname' => "lastname",
    'email' => "firstname.lastname@mail.test",
    'created_at' => date('Y-m-d H:i:s')
]);
