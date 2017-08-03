<?php

namespace Tourbillon\Dbal;

use PDO;

/**
 * Description of Transformer
 *
 * @author gjean
 */
abstract class Transformer {

    protected $value;

    private $transformValue;

    private $dataType;
    
    public function __construct($value) {
        $this->baseValue = $value;
        $this->dataType = PDO::PARAM_STR;
        $this->transformValue = $this->transform($value);
    }
    
    public function getBaseValue() {
        return $this->baseValue;
    }
    
    public function getTranformValue() {
        return $this->transformValue;
    }
    
    public function getDataType() {
        return $this->dataType;
    }
    
    public function setDataType($dataType) {
        $this->dataType = $dataType;
    }
    
    public abstract function transform($value);
}
