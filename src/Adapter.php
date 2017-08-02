<?php

namespace Tourbillon\Dbal;

use Exception;
use Tourbillon\Configurator\Configurator;

/**
 * Description of Adapter
 *
 * @author gjean
 */
abstract class Adapter
{
    protected $name;
    
    protected $config;
    
    public function __construct(Configurator $config, $name) {
        $this->config = $config->get($name);
        if (!$this->greatConfig()) {
            throw new Exception("Database Configuration for {$name} is not great");
        }
    }
        
    protected abstract function greatConfig();
    
    public function getConnection() {
        $class = $this->getConnectionClass($this->config['driver']);
        return new $class($this->config);
    }
    
    protected function getConnectionClass($driver) {
        return "\\Tourbillon\\Dbal\\Connection\\" . ucfirst(strtolower($driver)) . "Connection";
    }
}
