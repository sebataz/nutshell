<?php
namespace nutshell\model;

use nutshell\lang\Object;
use nutshell\lang\Map;
use nutshell\lang\halt\PropertyNotFound;

/**
 * <b>Model.clazz.php</b>: model of data
 * 
 * <p>The model is a representation of data that are saved on a memory support
 * (e.g.: database, file, xml, json, potatoes, ...). The model will have the 
 * handling method to manipulate the data: find, save, remove.</p>
 * 
 * <p>The model uses the same name as the model for the property name of the ID.</p>
 *
 * @package nutshell
 * @subpackage model
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @since 14.06.2010
 * @version 2.0
 */
abstract class Model extends Object implements IModel {
    
    /**
     * Holds a map of raw values queried from the memory support.
     *
     * @var Map A map of value
     */
    private $_Map;
    
    /**
     * Sets or returns the model's map.
     * 
     * @param Map $_Map A map of raw values or null.
     * @return Map The model's map.
     */
    protected function Map(Map $_Map = null) {
        // set map if any
        if ($_Map) $this->_Map = $_Map;
        
        // creates data map if not yet defined
        if (null === $this->_Map) 
            return $this->_Map = new Map($this->getObjectProperties()->toArray());
        else
            return $this->_Map;
    }

    /**
     * Sets the model ID.
     * 
     * @param mixed $_id The model ID.
     */
    final public function setID($_id) {
        try {
            $this->set($this->getClazz(), $_id);
        } catch (PropertyNotFound $H) {}
        
    }
    
    /**
     * Returns the model ID.
     * 
     * @return mixed The model ID.
     */
    final public function getID() {
        try {
            return $this->get($this->getClazz());
        } catch (PropertyNotFound $H) {
            return null;
        }
    }
    
    /**
     * Accesses the property using the methods <kbd>get</kbd>, <kbd>set</kbd> and
     * <kbd>add</kbd>. The magic methods allows you to call tha accessor by
     * concatenating the method call and the property name in one call 
     * (e.g.: $Model->getProperty(), $Model->setProperty('AValue'), $Model->addProperty($AModel))
     */
    public function __call($_method_name, $_args) {
        
        // extract property name from call
        if (!($count = preg_match('/(get|set|add)([a-zA-Z_]+)/', $_method_name, $match)))
            return parent::__call($_method_name, $_args);
        
        // call right accessor
        else  {
            switch ($match[1]) {
                case 'get': // property getter
                    return $this->get($match[2]);
                case 'set': // property setter
                    return $this->set($match[2], isset($_args[0])?$_args[0]:null);
                case 'add': // property adder
                    return $this->add($match[2], isset($_args[0])?$_args[0]:null);
            }
        }

    }
    
    /**
     * Returns the value of the property defined by <var>$_property_name</var>.
     * 
     * @param string $_property_name The property name.
     * @return mixed The property value.
     * @throws PropertyNotFound Thrwon if the property is not declared.
     */
    public function get($_property_name) {
        
        // check if property exist
        if (!$this->propertyExists($_property_name) && $this->getClazz() != $_property_name)
            throw new PropertyNotFound($this->getClazz(), $_property_name);
        
        // set property with raw value and return
        return $this->$_property_name = $this->Map()->get($_property_name);
    }
    
    /**
     * Sets the property value for the property defined by <var>$_property_name</var>.
     * 
     * @param string $_property_name The property name.
     * @param string $_value The property value.
     * @return mixed The property value.
     * @throws PropertyNotFound Thrwon if the property is not declared.
     */
    public function set($_property_name, $_value) {
        // check if property exist
        if (!$this->propertyExists($_property_name) && $this->getClazz() != $_property_name)
            throw new PropertyNotFound($this->getClazz(), $_property_name);
        
        // set the raw value
        $this->Map()->set($_property_name, $_value);
        
        // set the property value
        return $this->$_property_name = $_value;
    }
    
    /**
     * Adds a value to a collection defined by <var>$_property_name</var>.
     * 
     * @param string $_property_name The property name.
     * @param Model $_Model A model.
     * @return ArrayMap The model collection.
     * @throws PropertyNotFound Thrown if the property is not declare.
     */
    public function add($_property_name, Model $_Model) {
        
        // check if property exist
        if (!$this->propertyExists($_property_name))
            throw new PropertyNotFound($this->getClazz(), $_property_name);
        
        // create array map if needed
        if (null === $this->$_property_name)
            $this->$_property_name = new ArrayMap();
        
        // add model
        $this->$_property_name->add($_Model->getID(), $_Model);
        
        return $this->$_property_name;
    }
    

}
