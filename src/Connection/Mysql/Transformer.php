<?php

namespace Tourbillon\Dbal\Connection\Mysql;

use DateTime;
use Tourbillon\Dbal\Transformer as BaseTransformer;

/**
 * Description of Binder
 *
 * @author gjean
 */
class Transformer extends BaseTransformer {

    public function transform($value) {
        if ($value instanceof DateTime) {
            return $this->transformDateTimeToString($value);
        }
        return $value;
    }

    private function transformDateTimeToString(Datetime $value) {
        return $value->format('Y-m-d H:i:s');
    }
}
