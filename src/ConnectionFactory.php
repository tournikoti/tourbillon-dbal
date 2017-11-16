<?php

namespace Tourbillon\Dbal;

/**
 * Description of ManagerFactory
 *
 * @author gjean
 */
class ConnectionFactory {
    
    /**
     *
     * @var array
     */
    private $config;

    /**
     *
     * @var \Tourbillon\Dbal\Connection[]
     */
    private $connections;

    public function __construct(array $config) {
        $this->config = $config;
        $this->connections = array();
    }
    
    /**
     * 
     * @param type $name
     * @return \Tourbillon\Dbal\Connection
     */
    public function getConnection($name = 'default') {
        if (!array_key_exists($name, $this->connections)) {
            $adapter = AdapterFactory::getInstance()->createAdapter($this->config, $name);
            $this->connections[$name] = $adapter->getConnection();
        }
        return $this->connections[$name];
    }
}
