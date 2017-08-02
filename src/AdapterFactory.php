<?php

namespace Tourbillon\Dbal;

use Exception;
use Tourbillon\Configurator\Configurator;

/**
 * Description of AdapterFactory
 *
 * @author gjean
 */
class AdapterFactory {
    
    private static $instance;

    private function __construct() {
        
    }

    /**
     * 
     * @return self
     */
    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function createAdapter(Configurator $config, $name) {
        $class = $this->getAdapterClass($this->getDriver($config, $name));
        return new $class($config, $name);
    }
    
    protected function getAdapterClass($connectionName) {
        return "\\Tourbillon\\Dbal\\Adapter\\" . ucfirst(strtolower($connectionName)) . "Adapter";
    }
    
    protected function getDriver(Configurator $config, $name) {
        if (!array_key_exists('driver', $config->get($name))) {
            throw new Exception("Database configuration {$name} need a driver");
        }
        
        return $config->get($name)['driver'];
    }
}
