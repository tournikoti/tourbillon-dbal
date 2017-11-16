<?php

namespace Tourbillon\Dbal;

/**
 * Description of Connection
 *
 * @author gjean
 */
abstract class Connection {
    
    protected $config;

    public function __construct(array $config) {
        $this->config = $config;
        $this->build();
    }

    public abstract function build();
    
    public abstract function query($sql, array $param = array());
}
