<?php

use Tourbillon\Dbal\ConnectionFactory;

require '../vendor/autoload.php';

$config = include './config/database.php';

$connectionFactory = new ConnectionFactory($config['database']);

$connection = $connectionFactory->getConnection('default');

// ---
// UTILISATION DE BASE
// ---

$stmt = $connection->query("SELECT * FROM user WHERE created_at < :date");
$connection->bindParam($stmt, 'date', new DateTime());
$connection->execute($stmt);

while ($row = $connection->fetch($stmt)) {
    var_dump($row);
}

echo "<hr/>";

// ---
// UTILISATION DU QUERY BUILDER
// ---

$queryBuilder = $connection->createQueryBuilder()
        ->select('id', 'firstname')
        ->from('user')
        ->where('id = :id')
        ->setParameter('id', 1);

var_dump($connection->get($queryBuilder));

echo "<hr/>";

// ---
// INSERTION
// ---

$queryBuilder = $connection->createQueryBuilder()
        ->insert('user')
        ->set('firstname', 'Test')
        ->set('lastname', 'Test')
        ->set('email', 'test.test@test.test')
;

var_dump($queryBuilder->getQuery(), $queryBuilder->getParameters());

echo "<hr/>";

// ---
// MISE A JOUR
// ---

$queryBuilder = $connection->createQueryBuilder()
        ->update('user')
        ->set('firstname', 'Test')
        ->set('lastname', 'Test')
        ->set('email', 'test.test@test.test')
        ->where('id = :id')
        ->setParameter('id', 2)
;

var_dump($queryBuilder->getQuery(), $queryBuilder->getParameters());

echo "<hr/>";

// ---
// SUPPRESSION
// ---

$queryBuilder = $connection->createQueryBuilder()
        ->delete('user')
        ->where('id = :id')
        ->setParameter('id', 2)
;

var_dump($queryBuilder->getQuery(), $queryBuilder->getParameters());
