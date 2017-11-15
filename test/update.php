<?php

use Tourbillon\Configurator\ConfiguratorFactory;
use Tourbillon\Dbal\ConnectionFactory;

require '../vendor/autoload.php';

$configurator = ConfiguratorFactory::createInstance(realpath(__DIR__ . '/config/database.neon'));

$connectionFactory = new ConnectionFactory($configurator);

$connection = $connectionFactory->getConnection('default');

$connection->update('user', [
    'email' => "firstname.lastname.updated@mail.test",
], [
    'id' => 1
]);
