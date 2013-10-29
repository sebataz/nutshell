<?php
namespace nutshell\lang\halt;

/**
 * <b>PropertyNameNumeric.halt.php</b>: numeric propery name halt
 * 
 * <p>Thrown when trying to set a map property with a numeric name.</p>
 *
 * @package nutshell
 * @subpackage lang\halt
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @since 2013-06-26
 * @version 0.0
 */
class PropertyNameNumeric extends Halt {
    
    /**
     * Sets the halt message.
     * 
     * @param string $_clazz Clazz name.
     * @param string $_property Property name.
     */
    public function __construct($_clazz, $_property) {
        parent::__construct('numeric property name is not allowed in ' . $_clazz . '::' . $_property);
    }
}
