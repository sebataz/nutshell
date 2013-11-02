<?php
namespace nutshell\lang;

use \Iterator;

/**
 * <b>Iterable.clazz.php</b>: iterable object
 * 
 * <p>Implements the ability to iterate through an object 
 * (e.g. <kbd>foreach</kbd>), it is based on the properties of an object so any 
 * object could inherit from <kbd>Iterable</kbd>.</p>
 *
 * @abstract 
 * @package nutshell
 * @subpackage lang
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @since 2013-05-10
 * @version 0.0
 */
abstract class Iterable extends Object implements Iterator {
    
    /**
     * Contains the position at which the iteration is.
     * 
     * @var int $_position The position of the iteration.
     */
    private $_position = 0;
    
    /**
     * Rewind the <kbd>Iterable</kbd> to the first element.
     */
    public function rewind() {
        $this->_position = 0;
    }

    /**
     * Returns the current element.
     * 
     * @return mixed The current element.
     */
    public function current() {
        return $this->getObjectProperties()->get($this->getObjectProperties()->getKeys($this->_position));
    }

    /**
     * Returns the key of the current element.
     * 
     * @return mixed The key of the current element.
     */
    public function key() {
        return $this->getObjectProperties()->getKeys($this->_position);
    }

    /**
     * Moves forward to next element.
     */
    public function next() {
        ++$this->_position;
    }

    /**
     * This method is called after <kbd>Iterable::rewind()</kbd> and 
     * <kbd>Iterable::next()</kbd> to check if the current position is valid.
     * 
     * @return bool <b>TRUE</b> on success of <b>FALSE<b> on failure.
     */
    public function valid() {
        return $this->getObjectProperties()->keyExists($this->getObjectProperties()->getKeys($this->_position));
    }
}
