<?php

namespace Tourbillon\Dbal;

use Tourbillon\Configurator\Configurator;
use Exception;

/**
 * Description of Connection
 *
 * @author gjean
 */
abstract class Connection {
    
    protected $config;
    
    public function __construct(Configurator $config, $name) {
        $this->config = $config->get($name);
        if (!$this->greatConfig()) {
            throw new Exception("Database Configuration for " . get_class($this) . " is not great");
        }
        $this->build();
    }
    
    protected abstract function build();
    
    protected abstract function greatConfig();
}
