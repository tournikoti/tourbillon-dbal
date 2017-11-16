<?php

use Tourbillon\Configurator\ConfiguratorFactory;
use Tourbillon\Dbal\ConnectionFactory;

require '../vendor/autoload.php';

$config = include './config/database.php';

$connectionFactory = new ConnectionFactory($config['database']);

$connection = $connectionFactory->getConnection('default');

var_dump($connection);
