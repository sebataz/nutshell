<?php
namespace nutshell\lang\json;

use nutshell\lang\Map;

/**
 * <b>JSONObject.clazz.php</b>: JSON object
 * 
 * <p>A <kbd>JSONObject</kbd> is an extension of an <kbd>Map</kbd> which can
 * be instantiated directly from a <kbd>JSON</kbd> string.</p>
 *
 * @package nutshell
 * @subpackage lang\json
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @since 2013-06-19
 * @version 0.0
 */
class JSONObject extends Map {
    
    /**
     * Creates a <kbd>Map</kbd> from a <kbd>JSON</kbd> object passed as 
     * a string.
     * 
     * @param string $_json_string A <kbd>JSON</kbd> object.
     */
    public function __construct($_json_string) {
        parent::__construct(json_decode($_json_string, true));
    }
}
