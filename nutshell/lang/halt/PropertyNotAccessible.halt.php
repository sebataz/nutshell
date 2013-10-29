<?php
namespace nutshell\lang\halt;

/**
 * <b>PropertyNotAccessible.halt.php</b>: property not found halt.
 *
 * <p>Thrown when property is not declared or not found in called class.</p>
 * 
 * @package nutshell
 * @subpackage lang\halt
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 1.0
 * @since 2013-05-11
 */
class PropertyNotAccessible extends Halt {
    
    /**
     * Sets the halt message. 
     * 
     * @param string $_clazz_name The called class.
     * @param string $_property_name The called property.
     */
    public function __construct($_clazz_name, $_property_name) {
        parent::__construct('property not accessible directly ' . $_clazz_name . '::$' . $_property_name);
    }
}
