<?php
namespace nutshell\request\http;

use nutshell\lang\ArrayMap as ArrayMap;

/**
 * <b>RequestVariable.clazz.php</b>: request variable base class
 * 
 * <p>Wrapper for request variables.</p>
 *
 * @package nutshell
 * @subpackage request\http
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-28
 */
class Variable extends ArrayMap {
    
    /**
     * Checks if variable is set and return value or <b>NULL</b>.
     * 
     * @param string $_name Variable name.
     * @return mixed The value of the variable or <b>NULL</b> if not defined.
     */
    public function null($_name) {
        return $this->keyExists($_name) ? $this->get($_name) : null;
    }
    
    /**
     * Checks if variable is set and return value or default value.
     * 
     * @param string $_name Variable name.
     * @return mixed The value of the variable or the default value if not defined.
     */
    public function defaultValue($_name, $_default_value) {
        return $this->null($_name) ? $this->get($_name) : $_default_value;
    }
    
    /**
     * Stores the variable's value into session, if not yet stored, and returns
     * the value in session. Usefull to have persistent request variables.
     * 
     * @param string $_name Variable name.
     * @return mixed The value of the variable or <b>NULL</b> if not defined.
     */
    public function session($_name) {
        if ($this->keyExists($_name))
            if (Request::session()->null($_name) != $this->$_name)
                Request::session()->add($_name, $this->null($_name));
        
        return Request::session()->null($_name);
    }
}
