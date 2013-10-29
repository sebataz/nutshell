<?php
namespace nutshell\lang;

use nutshell\lang\json\JSONable;
use nutshell\lang\halt\PropertyNotFound;
use nutshell\lang\halt\PropertyAlreadySet;

/**
 * <b>ArrayMap.clazz.php</b>: collection of items
 * 
 * <p>Creates an iterable collection of items of mixed type.</p>
 *
 * @package nutshell
 * @subpackage lang
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @since 2013-05-09
 * @version 0.3
 */
class ArrayMap extends Iterable implements JSONable {
    
    /**
     * An <kbd>array</kbd> that can be indexed, associative or mixed containing 
     * the item of the <kbd>ArrayMap</kbd>.
     * 
     * @var array Array of items.
     */
    private $_items = array();

    /**
     * Parses an <kbd>array</kbd> into an <kbd>ArrayMap</kbd>, it goes through
     * the array recoursively. If a sub-array is found it will create a new
     * <kbd>ArrayMap</kbd> for it.
     * 
     * @param array $_array An array that can be indexed, associative or mixed.
     */
    public function __construct(array $_array=array()) {
        foreach ($_array as $key => $value) {
            
            // Checks if value is an array, in which case it creates a new ArrayMap,
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
        $this->_items[] = $_value;
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
        
        $this->_items[$_key] = $_value;
    }

    /**
     * Returns the value at the index defined by <var>$_key</var>.
     * 
     * @param mixed $_key Value to return.
     * @return mixed A value.
     */
    public function get($_key) {
        if (!$this->keyExists($_key))
            throw new PropertyNotFound('ArrayMap', $_key);
        
        return $this->_items[$_key];
    }
    
    /**
     * Returns an item of the <kbd>ArrayMap</kbd> at the position identified
     * by <var>$_position</var>.
     * 
     * @param int $_position Position to get.
     * @return mixed An item.
     */
    public function getElementAt($_position) {
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
        return array_key_exists($_key, $this->_items);
    }
    
    /**
     * Returns all the keys or a single of the key of the <kbd>ArrayMap</kbd>.
     * 
     * @param int $_position [optional] If specified, then only key at given
     *                                  position.
     * @return mixed An array of all the keys if <var>$_position</var> is given,
     *               otherwise the key for the given position.
     */
    public function getKeys($_position=null) {
        $array_keys = array_keys($this->_items);
        
        // Checks if position is inside the array.
        if ($_position < $this->count())
            return $_position===null?$array_keys:$array_keys[$_position];
    }
    
    /**
     * Counts all items in an <kbd>ArrayMap</kbd>.
     * @return int The number of items in <kbd>ArrayMap</kbd>.
     */
    public function count() {
        return count($this->_items);
    }
    
    /**
     * Returns the items of the <kbd>ArrayMap<kbd> into an <kbd>array</kbd>.
     * 
     * @return array An array of items.
     */
    public function toArray() {
        return self::mapToArray($this->_items);
    }
    
    /**
     * Converts an array of object into a plain array, and converts each obejct
     * into an array.
     * 
     * @param array $_array An mixed array.
     * @return array A plain array.
     */
    public static function mapToArray($_array) {
        if (is_array($_array)) 
            return array_map(array('self', 'mapToArray'), $_array);
        elseif ($_array instanceof Clazz)
            return array_map(array('self', 'mapToArray'), $_array->getObjectProperties()->toArray());
        else
            return $_array;
    }
        
    /**
     * @see JSONable::toJSON()
     */
    public function toJSON() {
        return json_encode($this->toArray());
    }
    
    /**
     * Override <kbd>Object::getObjectProperties()</kbd> an return the current
     * instance of <kbd>ArrayMap</kbd>.
     * 
     * @return ArrayMap This object.
     */
    public function getObjectProperties() {
        return $this;
    }
    
    
    /**
     * Merges this <kbd>ArrayMap</kbd> with a plain array. The merged array can
     * be appended a the end of the current array or it can overwrite any 
     * already set item of the array.
     * 
     * @param array $_array An array to merge.
     * @param type $_append If TRUE appends the new array a the end, otherwise
     *                      overwrites any double value.
     * @return ArrayMap An array map.
     */
    public function mergeWith(array $_array, $_append = false) {
        if ($_append)
            $temp_array = array_merge_recursive($this->toArray(), $_array);
        else
            $temp_array = array_replace_recursive($this->toArray(), $_array);
        
        foreach ($temp_array as $key => $value) {
            if (is_array($value))
                $this->_items[$key] = new ArrayMap($value);
            else
                $this->_items[$key] = $value;
         }
            
         
        return $this;
    }
    
    /**
     * @see ArrayMap::keyExists()
     */
    public function __isset($_key) {
        return $this->keyExists($_key);
    }

    /**
     * @see ArrayMap::add_2()
     */
    public function __set($_key, $_value) {
        $this->add_2($_key, $_value);
    }

    /**
     * @see ArrayMap::get()
     */
    public function __get($_key) {
        return $this->get($_key);
    }
}
