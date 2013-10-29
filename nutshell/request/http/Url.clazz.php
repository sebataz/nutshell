<?php
namespace nutshell\request\http; 

use nutshell\lang\Clazz as Clazz;

/**
 * <b>Url.clazz.php</b>: url utility class
 *
 * @package nutshell
 * @subpackage request\http
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-28
 */
abstract class Url extends Clazz {
    
    /**
     * Returns the hostname of the current url.
     * 
     * @return string The url hostname.
     */
    public static function hostname() {
        return $_SERVER['SERVER_NAME'];
    }
    
    /**
     * Retuns the query string of the current url.
     * 
     * @return string The query string.
     */
    public static function querystring() {
        return $_SERVER['QUERY_STRING'];
    }
}
