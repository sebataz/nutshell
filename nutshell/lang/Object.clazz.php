<?php
namespace nutshell\lang;

use nutshell\lang\halt\PropertyNotFound;
use nutshell\lang\halt\MethodNotFound;

/**
 * <b>Object.clazz.php</b>: base object
 * 
 * <p>Base class for all the objects of this framework, all object should derive
 * from this class. Clazz extends the standard php class in order to benefit of php oop
 * standards.</p>
 * 
 * <p>The class offers some basic functionality commonly used throughout the 
 * framework.</p>
 *
 * @package nutshell
 * @subpackage lang
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @since 2010-04-04
 * @version 1.0
 */
class Object extends Clazz {
    
    
    /**
     * Invoked if property is not declared inside the class.
     * 
     * @param string $_property_name Name of a property.
     * @throws PropertyNotFoundHalt Throws Halt if property doesn't exist. 
     */
    public function __get($_property_name) {
            throw new PropertyNotFound(self::getClazz(), $_property_name);
    }
    

    /**
     * Checks if the class method exists.
     * 
     * @param string $_method_name The method name.
     * @return bool <b>TRUE</b> if the method given by <var>$_method_name</var> has been 
     *              defined for the object, <b>FALSE</b> otherwise.
     */
    public function methodExists($_method_name) {
        return method_exists(self::getClazz(), $_method_name);
    }

    /**
     * Implements the overload for methods, based on the number of parameters
     * passed to the method calls the right callback with an array of
     * parameters.
     * 
     * @param string $_method_name The callable to be called.
     * @param array $_args The parameters to be passed to the method, as an
     *                     indexed array.
     * @throws MethodNotFoundHalt Throws Halt if the method doesn't exists.
     */
    public function __call($_method_name, $_args) {
        // If method exists calls the right overloaded method.
        $overloaded_method_name = $_method_name."_".count($_args);
        if ($this->methodExists($overloaded_method_name))
            return $this->callback($overloaded_method_name, $_args);
        
        return $this->callback($_method_name, $_args);
    }
    
    public function callback($_method_name, $_args = array()) {
        // Call method if exists
        if ($this->methodExists($_method_name))
            return call_user_func_array(array($this, $_method_name), $_args);
        
        // Throws Halt if method not found
        throw new MethodNotFound(self::getClazz(), $_method_name);
    }

    /**
     * Checks if the object or class has a property defined by <var>$_property_name</var>.
     * 
     * @param string $_property_name The name of the property.
     * @return bool <b>TRUE</b> if the property exists, <b>FALSE</b> if it
     *              doesn't exist or <b>NULL</b> in case of an error.
     */
    public function propertyExists($_property_name) {
        return property_exists(get_called_class(), $_property_name);
    }

    /**
     * <p>Returns an <kbd>ArrayMap</kbd> of the properties of the object. Only 
     * <kbd>public</kbd> and <kbd>protected</kbd> are returned, 
     * <kbd>private</kbd> properties are omitted.</p>
     * 
     * <p>If a property has not been assigned a value, it will be returned with a 
     * <b>NULL</b> value.</p>
     * 
     * @return ArrayMap An <kbd>ArrayMap</kbd> of non-static propertis for the
     *                   object.
     */
    public function getObjectProperties() {
        return new Collection(get_object_vars($this));
    }

    
    
    

    /**
     * Checks if the object is of this class or has this class as one of its 
     * parents. 
     * 
     * @param string $_clazz_name A class name.
     * @return bool <b>TRUE</b> if the object is of this class or has this class as one 
     *              of its parents, <b>FALSE</b> otherwise.
     */
    public function isA($_clazz_name) {
        return is_a($this, $_clazz_name);
    }
    
    /**
     * Check if the object is instance of clazz name.
     * 
     * @param string $_clazz_name A clazz name.
     * @return bool <b>TRUE</b> if instance of, otherwise <b>FALSE</b>.
     */
    public function isInstanceOf($_clazz_name) {
        return $this instanceof $_clazz_name;
    }
    
    /**
     * Casts an object to another class, by serializing the object and then
     * unserializing it to the new class instance.
     * 
     * @param string $_clazz_name A class name.
     * @return Object The casted object.
     */
    public function castTo($_clazz_name) {
        return unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($_clazz_name) . ':"' . $_clazz_name . '"', serialize($this)));
    }
}
