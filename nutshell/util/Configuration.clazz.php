<?php
namespace nutshell\util;

use nutshell\lang\Clazz;
use nutshell\lang\Collection;
use nutshell\lang\halt\Halt;
use nutshell\data\file\FileNotFound;

/**
 * <b>Configuration.clazz.php</b>: configuration file wrapper
 * 
 * <p>Creates an array map from a config file.</p>
 * 
 * <p>A configuration file basically contains only one variable, an associative
 * multi-dimensional array. The variable name must be <var>$cfg</var> (e.g.:
 * $cfg['AnExample']['AValue'] = 'Something')</p>
 * 
 * <p><u>NOTE</u>: the configuration can load multiple configuration file, each
 * new configuration file will overwrite any value with the same key.</p>
 * 
 * @abstract
 * @package nutshell
 * @subpackage util
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-07-11
 */
class Configuration extends Clazz {
    
    /**
     * Holds all the configuration entry into an <kbd>Collection</kbd>.
     * 
     * @var Collection An array map of configuration values.
     */
    private static $_Configuration;
    
    /**
     * Loads the configuration file and creates a singleton instance of an
     * <kbd>Collection</kbd> containing the whole configuration.
     * 
     * @param string $_config_file Path to configuration file.
     * @throws FileNotFound Thrown if configuration file is not found.
     */
    public static function load($_config_file) {
        
        // check if file exist
        if (!file_exists($_config_file))
            throw new FileNotFound($_config_file);
        
        // create singleton instance
        if (!self::$_Configuration)
            self::$_Configuration = new Collection();
        
        // create configuration
        include $_config_file;
        self::$_Configuration->union(new Collection($cfg));
    }
    
    /**
     * Returns the configuration array map. Configuration variables are
     * accessed like object properties. (e.g.: Configuration::at()->AnExample->AValue;)
     * 
     * @return mixed A configuration value.
     * @throws Halt Thrown if configuration file has not been loaded.
     */
    public static function at() {
        if (!self::$_Configuration)
            throw new Halt('configuration file not loaded');

        return self::$_Configuration;
    }
    
}
