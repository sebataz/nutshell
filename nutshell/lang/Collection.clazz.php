<?php
namespace nutshell\lang;

use nutshell\lang\json\JSONable;
use nutshell\lang\halt\PropertyNotFound;
use nutshell\lang\halt\PropertyAlreadySet;

/**
 * <b>Collection.clazz.php</b>: collection of objects
 * 
 * <p>Creates an iterable collection of objects of mixed type.</p>
 *
 * @package nutshell
 * @subpackage lang
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @since 2013-05-09
 * @version 0.3
 */
class Collection extends Iterable implements JSONable {
    
    /**
     * An <kbd>array</kbd> that can be indexed, associative or mixed containing 
     * the item of the <kbd>Collection</kbd>.
     * 
     * @var array Array of objects.
     */
    private $_objects = array();

    /**
     * Parses an <kbd>array</kbd> into an <kbd>Collection</kbd>, it goes through
     * the array recoursively. If a sub-array is found it will create a new
     * <kbd>Collection</kbd> for it.
     * 
     * @param array $_array An array that can be indexed, associative or mixed.
     */
    public function __construct(array $_array=array()) {
        foreach ($_array as $key => $value) {
            
            // Checks if value is an array, in which case it creates a new Collection,
            // otherwise adds the as a new value.
            if (is_array($value)) {
                $this->add($key, new self($value));
            } else
                $this->add($key, $value);
        }
    }

    /**
     * Push the new value at the end of the current item list.
     * 
     * @param mixed $_value Value to add.
     */
    protected function add_1($_value) {
        $this->_objects[] = $_value;
    }
    
    /**
     * Adds a new item to the item list, if the key exists the value will be
     * overwritten.
     * 
     * @param mixed $_key Key to add.
     * @param mixed $_value Value to add.
     */
    protected function add_2($_key, $_value) {
        if ($this->keyExists($_key))
            throw new PropertyAlreadySet($this->getClazz(), $_key);
        
        $this->_objects[$_key] = $_value;
    }
    
    public function set($_key, $_value) {
        if (!$this->keyExists($_key))
            throw new PropertyNotFound($this->getClazz(), $_key);
        
        $this->_objects[$_key] = $_value;
    }

    /**
     * Returns the value at the index defined by <var>$_key</var>.
     * 
     * @param mixed $_key Value to return.
     * @return mixed A value.
     */
    public function get($_key) {
        if (!$this->keyExists($_key))
            throw new PropertyNotFound($this->getClazz(), $_key);
        
        return $this->_objects[$_key];
    }
    
    public function __get($_key) {
        return $this->get($_key);
    }
    
	
    /**
     * Returns the value at the index defined by <var>$_key</var> or 
     * a default value instead if key index doesn't exists.
     */
    public function getDefault($_key, $_default_value=null) {
        return $this->keyExists($_key) ? $this->get($_key) : $_default_value;
    }
    
    /**
     * Returns an item of the <kbd>Collection</kbd> at the position identified
     * by <var>$_position</var>.
     * 
     * @param int $_position Position to get.
     * @return mixed An item.
     */
    public function getObjectAt($_position) {
        return $this->get($this->getKeys($_position));
    }
    
    /**
     * Checks if the given key defined by <var>$_key</var> or index exists in 
     * the array.
     * 
     * @param mixed $_key Value to check.
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function keyExists($_key) {
        return array_key_exists($_key, $this->_objects);
    }
    
    /**
     * Returns all the keys or a single of the key of the <kbd>Collection</kbd>.
     * 
     * @param int $_position [optional] If specified, then only key at given
     *                                  position.
     * @return mixed An array of all the keys if <var>$_position</var> is given,
     *               otherwise the key for the given position.
     */
    public function getKeys($_position=null) {
        $array_keys = array_keys($this->_objects);
        
        // Checks if position is inside the array.
        if ($_position < $this->count())
            return $_position===null?$array_keys:$array_keys[$_position];
    }
    
    /**
     * Counts all objects in an <kbd>Collection</kbd>.
     * @return int The number of objects in <kbd>Collection</kbd>.
     */
    public function count() {
        return count($this->_objects);
    }
    
    /**
     * Returns the objects of the <kbd>Collection<kbd> into an <kbd>array</kbd>.
     * 
     * @return array An array of objects.
     */
    public function toArray() {
        return $this->_objects;
    }
        
    /**
     * @see JSONable::toJSON()
     */
    public function toJSON() {
        $array = array();
        
        foreach ($this->toArray() as $key => $object)
            $array[$key] = $object instanceof JSONable ? $object->toArray() : $object;
        
        return json_encode($array);
    }
    
    public function __toString() {
        return $this->toJSON();
    }
    
    /**
     * Override <kbd>Object::getObjectProperties()</kbd> an return the current
     * instance of <kbd>Collection</kbd>.
     * 
     * @return Collection This object.
     */
    public function getObjectProperties() {
        return $this;
    }
    
    
    
    /**
     * Merges this <kbd>Collection</kbd> with another. The merged array can
     * be appended a the end of the current array or it can overwrite any 
     * already set item of the array.
     * 
     * @param array $_array An array to merge.
     * @param type $_overwrite If TRUE appends the new array a the end, otherwise
     *                      overwrites any double value.
     * @return Collection An array map.
     */    
    public function union(Collection $_Collection, $_overwrite = true) {
        if ($_overwrite)
            $temp_array = array_merge_recursive($this->toArray(), $_Collection->toArray());
        else 
            $temp_array = $this->toArray() + $_Collection->toArray();
        
        $this->_objects = $temp_array;
        return new self($temp_array);
    }
    
    /**
     * Computes the diffirence with another <kbd>Collection</kbd>.
     * 
     * @param Collection $Collection A collection of objects.
     * @return Collection A collection of different elements.
     */
    public function difference(Collection $Collection) {
        return new self(array_diff($this->_objects, $Collection->toArray()));
    }
    
    /**
     * Computes the intersection with another <kbd>Collection</kbd>.
     * 
     * @param Collection $Collection A collection of objects.
     * @return Collection A collection of intersected objects.
     */
    public function intersect(Collection $Collection) {
        return new self(array_intersect($this->_objects, $Collection->toArray()));
    }

    public function remove($_key) {
        if ($this->keyExists($_key))
            unset($this->_objects[$_key]);
    }
}
