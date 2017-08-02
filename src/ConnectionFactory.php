<?php

namespace Tourbillon\Dbal;

use Tourbillon\Configurator\Configurator;
use Exception;

/**
 * Description of ManagerFactory
 *
 * @author gjean
 */
class ConnectionFactory {
    
    /**
     *
     * @var Configurator
     */
    private $config;

    /**
     *
     * @var \Tourbillon\Dbal\Connection[]
     */
    private $connections;

    public function __construct(Configurator $config) {
        $this->config = $config;
        $this->connections = array();
    }
    
    public function getConnection($name = 'default') {
        if (!array_key_exists($name, $this->connections)) {
            $adapter = AdapterFactory::getInstance()->createAdapter($this->config, $name);
            $this->connections[$name] = $adapter->getConnection();
        }
        return $this->connections[$name];
    }
}
