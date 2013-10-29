<?php

namespace nutshell\lang;

class ValuePair extends Object {
    private $_name;
    private $_value;
    
    public function __construct($_name, $_value) {
        $this->_name = $_name;
        $this->_value = $_value;
    }
    
    public function getName() {
        return $this->_name;
    }
    
    public function getValue() {
        return $this->_value;
    }
}
