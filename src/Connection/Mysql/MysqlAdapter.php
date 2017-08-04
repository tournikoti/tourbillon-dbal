<?php

namespace Tourbillon\Dbal\Connection\Mysql;

use Tourbillon\Dbal\Adapter;

/**
 * Description of MysqlAdapter
 *
 * @author gjean
 */
class MysqlAdapter extends Adapter
{

    protected function greatConfig() {
        return array_key_exists('host', $this->config)
                && array_key_exists('database', $this->config) 
                && array_key_exists('user', $this->config)
                && array_key_exists('password', $this->config);
    }

}
