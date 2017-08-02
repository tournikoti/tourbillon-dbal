<?php

namespace Tourbillon\Dbal\Connection;

use Tourbillon\Dbal\Connection;
use PDO;

/**
 * Description of MysqlConnection
 *
 * @author gjean
 */
class MysqlConnection extends Connection {

    /**
     *
     * @var PDO
     */
    private $pdo;

    public function build() {
        $this->pdo = new PDO($this->getDsn(), $this->config['user'], $this->config['password']);
    }

    public function query($sql) {
        return $this->pdo->query($sql);
    }

    private function getDsn() {
        $dsn = "mysql:host={$this->config['host']};dbname={$this->config['database']}";

        if (array_key_exists('charset', $this->config)) {
            $dsn .= ";charset=utf8";
        }


        return $dsn;
    }
}