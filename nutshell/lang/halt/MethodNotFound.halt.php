<?php
namespace nutshell\lang\halt;

/**
 * <b>MethodNotFound.halt.php</b>: method not found halt
 * 
 * <p>Thrown when method in class is not declared or not found for the called class.</p>
 *
 * @package nutshell
 * @subpackage lang\halt
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 1.0
 * @since 2013-05-11
 */
class MethodNotFound extends Halt {
    
    /**
     * Sets the halt message.
     * 
     * @param string $_clazz_name Clazz name.
     * @param string $_method_name Method name.
     */
    public function __construct($_clazz_name, $_method_name) {
        parent::__construct('method not found ' . $_clazz_name . '::' . $_method_name . '()');
    }
}
