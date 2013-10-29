<?php

final class Nutshell {
    public static $project = 'nutshell';
    public static $description = 'a php framework';
    public static $author = 'sebataz &lt;sebastien.rigoni@gmail.com&gt;';
    public static $version = 0.6;
    public static $features = array('autoload' => 'classes autoloader',
                                    'mvc' => 'model-view-controller',
                                    'orm' => 'object-relational mapping',
                                    'request' => 'request handler');
    
    public static function info() {
        echo 'developed by ', self::$author, '<br />';
        echo self::$project,' v',self::$version, ' is ', self::$description,'<br />';
        echo 'features:<br /><ul>';
        foreach (self::$features as $feature_name => $feature_description)
            echo '<li><strong>', $feature_name, '</strong> ', $feature_description, '</li>';
        echo '</ul>';
    }
}



//----------------------------------------------------------------------------//
//                          main runtime settings                             //
//----------------------------------------------------------------------------//
error_reporting(E_ALL);
define('DS', DIRECTORY_SEPARATOR);



//----------------------------------------------------------------------------//
//                           nutshell class loader                            //
//----------------------------------------------------------------------------//
final class NutshellLoader {
    
    /**
     * Holds the extensions of class files.
     * 
     * @var array The default classes extensions.
     */
    private static $_autoloadExtensions = array('.clazz.php', 
                                                '.interface.php',
                                                '.halt.php');
    
    /**
     * Holds the registered namespace and the relative path to the class
     * package root.
     *
     * @var array List of class packages.
     */
    private static $_namespaceIncludePath = array();
    

    /**
     * Loads a single class file.
     * 
     * @param string $_clazz_name The clazz name.
     */
    public static function loadClazz($_clazz_name) {
       
        // parse clazz name
        $clazz_path = explode('\\', $_clazz_name);
        $namespace = $clazz_path[0];
        
        // check if clazz exist in registered namespaces
        if (!key_exists($namespace, self::$_namespaceIncludePath))
             return;
        
        // get class file path
        $clazz_path = self::$_namespaceIncludePath[$namespace]
                    . DS . implode(DS, $clazz_path);
        
        // loop through extensions to find correct file
        foreach (self::$_autoloadExtensions as $ext) {
            if (file_exists($clazz_path . $ext)) {
                include $clazz_path . $ext;
                break;
            }
        }
    }

    /**
     * Register the class loader callable.
     * 
     * @param string $_callable A valid callback.
     */
    public static function registerClazzLoader($_callable) {
        spl_autoload_register(null, false);
        spl_autoload_extensions(implode(',', self::$_autoloadExtensions));
        spl_autoload_register($_callable, false);
    }
    
    /**
     * Handles a non-caught halt.
     * 
     * @param Halt $Halt An halt.
     */
    public static function handleHalt(nutshell\lang\halt\Halt $Halt) {
        if (method_exists($Halt, 'restore'))
            $Halt->restore();
        else 
            echo 'Uncaught Exception: ', $Halt->getMessage();
    }
    
    /**
     * Register the main halt handler, for all non-caught halt.
     * 
     * @param string $_callable A valid callback.
     */
    public static function registerHaltHandler($_callable) {
        set_exception_handler($_callable);
    }
    
    /**
     * Register a namespace and its respective path.
     * 
     * @param string $_include_path The root path of a namespace.
     */
    public static function registerNamespaceIncludePath($_include_path) {
        self::$_namespaceIncludePath[basename($_include_path)] = dirname($_include_path);
    }
}



//----------------------------------------------------------------------------//
//                        load nutshell framework                             //
//----------------------------------------------------------------------------//
NutshellLoader::registerClazzLoader(array('NutshellLoader', 'loadClazz'));
NutshellLoader::registerHaltHandler(array('NutshellLoader', 'handleHalt'));
NutshellLoader::registerNamespaceIncludePath(__DIR__);
