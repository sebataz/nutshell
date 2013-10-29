<?php
namespace nutshell\util;

use nutshell\lang\Clazz;
use nutshell\lang\halt\Halt;

/**
 * <b>Debugger.clazz.php</b>: debugging utility class
 * 
 * <p>The class encloses code inside a <kbd>try</kbd> and <kbd>catch</kbd> block.</p>
 *
 * @package nutshell
 * @subpackage util
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-07-11
 */
class Debugger extends Clazz {
    
    /**
     * Tries a string of PHP code using the php <kbd>eval()</kbd> function.
     * 
     * @param string $_code A string of PHP code.
     */
    public static function tryCode($_code) {
        try {
            eval($_code);
        } catch (Halt $Halt) { $Halt->restore(); die(); }
    }
    
    /**
     * Tries a PHP script file.
     * 
     * @param string $_script_file Path to script file.
     */
    public static function tryScript($_script_file) {
        try {
            include $_script_file;
        } catch (Halt $Halt) { $Halt->restore(); die(); }
    }
    
    /**
     * Tries and times a script file.
     * 
     * @param type $_script_file
     */
    public static function timeScript($_script_file) {
        $Timer = new Timer();
        self::tryScript($_script_file);
        echo '<hr />';
        $Timer->dumpTime();
    }
}


