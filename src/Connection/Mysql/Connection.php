<?php

namespace Tourbillon\Dbal\Connection\Mysql;

use Tourbillon\Dbal\Connection as BaseConnection;
use Tourbillon\Dbal\Connection\Mysql\Binder;
use PDOStatement;
use PDO;

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
        $stmt->execute();
    }
    
    public function fetch(PDOStatement $stmt, $dataType = PDO::FETCH_OBJ) {
        return $stmt->fetch($dataType);
    }
    
    public function fetchAll(PDOStatement $stmt, $dataType = PDO::FETCH_OBJ) {
        return $stmt->fetchAll($dataType);
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
