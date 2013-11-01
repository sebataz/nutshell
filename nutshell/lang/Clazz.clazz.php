<?php
namespace nutshell\lang;

use \stdClass;
use nutshell\lang\halt\MethodNotFound;

/**
 * <b>Clazz.clazz.php</b>: base class
 * 
 * <p>All the class of this framework are derived from this. Clazz extends the 
 * standard php class in order to benefit of php oop standards.</p>
 * 
 * <p>The class offers some basic functionality commonly used throughout the 
 * framework.</p>
 *
 * @abstract
 * @package nutshell
 * @subpackage lang
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @since 2010-04-04
 * @version 1.0
 */
abstract class Clazz extends stdClass {
    
    /**
     * Invoked when a static method is not declared in the called class. It 
     * throws an Halt.
     * 
     * @param string $_method_name Name of the called method.
     * @param array $_args Parameters passed to the method.
     * @throws MethodNotFoundHalt Throws Halt if method doesn't exists.
     */
    public static function  __callStatic($_method_name,  $_args) {
        throw new MethodNotFound(self::getClazz(true), $_method_name);
    }

    /**
     * Returns the name of the called class.
     * 
     * @return string The class name.
     */
    public static function getClazz($_full_path=false) {
        $clazz = str_replace('\\', '', substr('\\' . get_called_class(), strrpos(get_called_class(), '\\')+1));
        return $_full_path ? get_called_class() : $clazz;
    }
    
    /**
     * Returns an associative array of declared properties visible from the 
     * current scope, with their default value. The resulting array elements are
     * in the form of varname => value. In case of an error, it returns FALSE.
     * 
     * @return array Default properties of a class.
     */
    public static function getClazzProperties() {
        return new Collection(get_class_vars(self::getClazz(true)));
    }
}
