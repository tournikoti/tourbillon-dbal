<?php

namespace Tourbillon\Dbal\Connection\Mysql;

use Tourbillon\Dbal\Connection as BaseConnection;
use Tourbillon\Dbal\Connection\Mysql\QueryBuilder;
use PDOStatement;
use PDO;
use Exception;

/**
 * Description of MysqlConnection
 *
 * @author gjean
 */
class Connection extends BaseConnection {

    /**
     *
     * @var PDO
     */
    private $pdo;

    public function build() {
        $this->pdo = new PDO($this->getDsn(), $this->config['user'], $this->config['password']);
    }

    public function query($sql, array $param = array()) {
        $stmt = $this->pdo->prepare($sql);
        $this->bindParams($stmt, $param);
        return $stmt;
    }
    
    public function execute(PDOStatement $stmt) {
        if (!$stmt->execute()) {
            throw new Exception("SQL Error {$stmt->errorInfo()[0]} {$stmt->errorInfo()[2]}");
        }
    }
    
    public function fetch(PDOStatement $stmt, $dataType = PDO::FETCH_OBJ) {
        return $stmt->fetch($dataType);
    }
    
    public function fetchAll(PDOStatement $stmt, $dataType = PDO::FETCH_OBJ) {
        return $stmt->fetchAll($dataType);
    }
    
    public function insert($table, array $data) {
        $queryBuilder = $this->createQueryBuilder()->insert($table);
              
        foreach ($data as $key => $value) {
            $queryBuilder->set($key, $value);
        }
        
        $stmt = $this->query($queryBuilder->getQuery(), $queryBuilder->getParameters());
        return $this->execute($stmt);
    }
    
    public function update($table, array $data, array $condition = array()) {
        $queryBuilder = $this->createQueryBuilder()->update($table);
              
        foreach ($data as $key => $value) {
            $queryBuilder->set($key, $value);
        }
        
        foreach ($condition as $key => $value) {
            $queryBuilder->where("$key = :$key", [$key => $value]);
        }
        
        $stmt = $this->query($queryBuilder->getQuery(), $queryBuilder->getParameters());
        return $this->execute($stmt);
    }
    
    /**
     * 
     * @param type $table
     * @param array $condition
     */
    public function delete($table, array $condition = array()) {
        $queryBuilder = $this->createQueryBuilder()->delete($table);

        foreach ($condition as $key => $value) {
            $queryBuilder->where("$key = :$key", [$key => $value]);
        }
        
        $stmt = $this->query($queryBuilder->getQuery(), $queryBuilder->getParameters());
        return $this->execute($stmt);
    }
    
    /**
     * Return \Tourbillon\Dbal\Connection\Mysql\QueryBuilder
     */
    public function createQueryBuilder() {
        return new QueryBuilder();
    }
    
    public function bindParams(PDOStatement $stmt, array $param) {
        foreach ($param as $key => $value) {
            $this->bindParam($stmt, $key, $value);
        }
    }
    
    public function bindParam(PDOStatement $stmt, $key, $value) {
        $transformer = new Transformer($value);   
        $stmt->bindParam($key, $transformer->getTranformValue(), $transformer->getDataType());
    }

    private function getDsn() {
        $dsn = "mysql:host={$this->config['host']};dbname={$this->config['database']}";

        if (array_key_exists('charset', $this->config)) {
            $dsn .= ";charset=utf8";
        }


        return $dsn;
    }
}
