<?php

namespace Tourbillon\Dbal;

use Tourbillon\Configurator\Configurator;

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
            $class = $this->getConnectionClass($this->getDriver($this->config, $name));
            $this->connections[$name] = new $class($this->config, $name);
        }
        return $this->connections[$name];
    }

    private function getConnectionClass($connectionName) {
        return "\\Tourbillon\\Dbal\\Connection\\" . ucfirst(strtolower($connectionName)) . "Connection";
    }
    
    private function getDriver(Configurator $config, $name) {
        return array_key_exists('driver', $config->get($name)) ? $config->get($name)['driver'] : null;;
    }
}
