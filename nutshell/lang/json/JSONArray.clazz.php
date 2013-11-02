<?php
namespace nutshell\lang\json;

use nutshell\lang\Collection;

/**
 * <b>JSONArray.clazz.php</b>: JSON array
 * 
 * <p>A <kbd>JSONArray</kbd> is an extension of an <kbd>Collection</kbd> which can
 * be instantiated directly from a <kbd>JSON</kbd> string.</p>
 *
 * @package nutshell
 * @subpackage lang\json
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @since 2013-06-19
 * @version 0.0
 */
class JSONArray extends Collection {
    
    /**
     * Creates an <kbd>Collection</kbd> from a <kbd>JSON</kbd> array passed as 
     * a string.
     * 
     * @param string $_json_string A <kbd>JSON</kbd> array.
     */
    public function __construct($_json_string) {
        parent::__construct(json_decode($_json_string, true));
    }
}
