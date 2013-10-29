<?php
namespace nutshell\lang\halt;

/**
 * <b>PropertyNotFoundHalt.halt.php</b>: property not found halt.
 *
 * <p>Thrown when property is not declared or not found in called class.</p>
 * 
 * @package nutshell
 * @subpackage lang\halt
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 1.0
 * @since 2013-05-11
 */
class PropertyNotFound extends Halt {
    
    /**
     * Sets the halt message
     * 
     * @param string $_clazz_name Clazz name.
     * @param string $_property_name Property name.
     */
    public function __construct($_clazz_name, $_property_name) {
        parent::__construct('property not found ' . $_clazz_name . '::$' . $_property_name);
    }
}
