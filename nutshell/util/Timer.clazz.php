<?php
namespace nutshell\util;

use nutshell\lang\Object;

/**
 * <b>Timer.clazz.php</b>: script timer
 * 
 * <p>Returns the time elapsed between the creation of an istance of <kbd>Timer</kbd>
 * and the method <kbd>getTime()</kbd>.</p>
 *
 * @package nutshell
 * @subpackage util
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-11-07
 */
class Timer extends Object {
    
    /**
     * The start time is set when the class is istantiated.
     * 
     * @var int Start time.
     */
    private $_start_time = 0;
    
    /**
     * Sets the start time for the timer.
     */
    public function __construct() {
        list($usec, $sec) = explode(' ',microtime());
        $this->_start_time =  ((float)$usec + (float)$sec);
    }
    
    /**
     * Returns the time elapsed since class instantiation.
     * 
     * @return int Number of seconds elapsed.
     */
    public function getTime() {
        list($usec, $sec) = explode(' ',microtime());
        $stop_time = ((float)$usec + (float)$sec);
        return $stop_time - $this->_start_time;
    }
    
    /**
     * Prints a formatted string of the elapsed time.
     */
    public function dumpTime() {
        var_dump(sprintf('%.4f sec', $this->getTime()));
    }
}
