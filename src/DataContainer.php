<?php
namespace Sirius\Forms;

class DataContainer extends \ArrayObject {
    
    function set($nameOrArray, $value = null) {
        if (is_array($nameOrArray)) {
            foreach ($nameOrArray as $k => $v) {
                $this->set($k, $v);
            }
            return;
        }
        if (!is_string($nameOrArray)) {
            throw new \InvalidArgumentException('Only strings or arrays are accepted as first argument of the set() method of the DataContainer class');
        }
        if ($value !== null) {
            $this[$nameOrArray] = $value;
        } elseif ($value === null && isset($this[$nameOrArray])) {
            unset($this[$nameOrArray]);
        }
    }
    
    function get($name) {
        return isset($this[$name])
        ? $this[$name]
        : null;
    }
    
    function getAll() {
        return $this->getArrayCopy();
    }
    
}