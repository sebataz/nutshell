<?php
namespace nutshell\lang;

use nutshell\lang\json\JSONable;
use nutshell\lang\halt\PropertyNameNumeric;
use nutshell\lang\halt\PropertyNotFound;

/**
 * <b>Map.clazz.php</b>: mapped object
 * 
 * <p>A <kbd>Map</kbd> is an object which has serves to gather single properties
 * into a single object.</p>
 *
 * @package nutshell
 * @subpackage data\model\map
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.1
 * @since 2010-06-14
 */
class Map extends Object Implements JSONable {
     
    /**
     * Parses an <kbd>array</kbd> into a <kbd>Map</kbd>, it goes through
     * the array recoursively. If a sub-array is found it will create a new
     * <kbd>Map</kbd> (if associative keys are used), otherwise a new 
     * <kbd>ArrayMap</kbd> will be creted instead.
     * 
     * @param array $_array An array that can be indexed, associative or mixed.
     */
    public function __construct(array $_array=array()) {
        foreach ($_array as $key => $value) {
            
            // numeric property name not allowed
            if (is_numeric($key))
                throw new PropertyNameNumeric($this->getClazz(), $key);
            
            // array with all non-numeric keys set a new Map
            if ( (is_array($value)) 
              && !(bool)count(array_filter(array_keys($value), 'is_numeric')) ) 
                $this->set($key, new Map($value));
            
            // array with mixed keys set a new ArrayMap
            elseif (is_array($value))
                $this->set($key, new ArrayMap($value));
            
            // set property value
            else
                $this->set($key, $value);
        }
    }
    
    /**
     * Return the value with the key identified by <var>$_property_name</var>.
     * 
     * @param string $_property_name A property name.
     * @return mixed A value.
     * @throws PropertyNotFound Thrown if key does not exist.
     */
    public function get($_property_name) {
        
        // property exist?
        if (!$this->getObjectProperties()->keyExists($_property_name))
            throw new PropertyNotFound($this->getClazz(), $_property_name);
        
        return $this->$_property_name;
    }
    
    /**
     * Sets a property by <var>$_property_name</var> and <var>$_value</var>
     * 
     * @param string $_property_name A property name.
     * @param mixed $_value A property value.
     */
    public function set($_property_name, $_value) {
        $this->$_property_name = $_value;
    }

    
    /**
     * Returns an <kbd>ArrayMap</kbd> of the property of this <kbd>Map</kbd>, it
     * gets the value of each property accessing the getter method, which could 
     * be overwritten for a child class. So that the value returned is always
     * the actualized one.
     * 
     * @return ArrayMap An array map.
     */
    public function toArrayMap() {
        $Collection = new ArrayMap();
        
        // set property value to collection item
        foreach ($this->getObjectProperties()->getKeys() as $_property_name)
            $Collection->add($_property_name, $this->get($_property_name));
        
        return $Collection;        
    }
    
    /**
     * @see ArrayMap::toArray()
     */
    public function toArray() {
        return $this->toArrayMap()->toArray();
    }

    /**
     * @see JSONable::toJSON()
     */
    public function toJSON() {
        return json_encode($this->toArray());
    }
}
