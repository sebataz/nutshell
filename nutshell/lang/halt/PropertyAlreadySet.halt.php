<?php
namespace nutshell\lang\halt;

/**
 * <b>PropertyAlreadySet.halt.php</b>: property already set halt
 * 
 * <p>Thrown when an array map item is already set.</p>
 *
 * @package nutshell
 * @subpackage lang\halt
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @since 2013-06-26
 * @version 0.0
 */
class PropertyAlreadySet extends Halt {
    
    /**
     * Sets the halt message.
     * 
     * @param string $_clazz Clazz name.
     * @param string $_property Property name.
     */
    public function __construct($_clazz, $_property) {
        parent::__construct('property already set ' . $_clazz . '::$' . $_property);
    }
}
