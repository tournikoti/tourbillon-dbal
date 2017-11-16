<?php

namespace Tourbillon\Dbal;

use Exception;

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
    
    public function createAdapter(array $config, $name) {
        $class = $this->getAdapterClass($this->getDriver($config, $name));
        return new $class($config, $name);
    }
    
    protected function getAdapterClass($connectionName) {
        $name = ucfirst(strtolower($connectionName));
        return "\\Tourbillon\\Dbal\\Connection\\" . $name . "\\" . $name . "Adapter";
    }
    
    protected function getDriver(array $config, $name) {
        if (!array_key_exists($name, $config))
            throw new Exception("Database configuration {$name} does not exist");
            
        if (!array_key_exists('driver', $config[$name]))
            throw new Exception("Database configuration {$name} need a driver");
        
        return $config[$name]['driver'];
    }
}
