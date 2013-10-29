<?php
namespace nutshell\lang\json;

/**
 * <b>JSONInterface.interface.php</b>: JSONable object
 * 
 * <p>Every object that can be converted to a JSON array must implement this 
 * interface. The method <kbd>toJSON()</kbd> provides a translation of the 
 * object to a JSON format.</p>
 * 
 * @package nutshell
 * @subpackage lang\json
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-11-07
 */
interface JSONable {
    
    /**
     * Translates the object to JSON.
     * 
     * @return string The JSON string.
     */
    public function toJSON();
}