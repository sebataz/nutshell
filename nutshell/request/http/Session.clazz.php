<?php
namespace nutshell\request\http;

/**
 * <b>SessionVariable.clazz.php</b>: session variables
 * 
 * <p>Wrapper for session variables.</p>
 *
 * @package nutshell
 * @subpackage request\http
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-29
 */
class Session extends Variable {
    
    /**
     * Starts session and creates an <kbd>ArrayMap</kbd> for the session
     * variables.
     */
    public function __construct() {
        session_start();
        parent::__construct($_SESSION);
    }
    
    /**
     * Push the new value at the end of the current item list and into the session
     * array.
     * 
     * @param mixed $_value Value to add.
     */
    protected function add_1($_value) {
        parent::add_1($_value);
        $_SESSION[] = $_value;
    }
    
    /**
     * Adds a new item to the item list and the session, if the key exists the 
     * value will be overwritten.
     * 
     * @param mixed $_key Key to add.
     * @param mixed $_value Value to add.
     */
    protected function add_2($_key, $_value) {
        parent::add_2($_key, $_value);
        $_SESSION[$_key] = $_value;
    }
}
