<?php
namespace nutshell\data\db;

use nutshell\lang\Clazz;
use nutshell\util\Configuration;

/**
 * <b>Database.clazz.php</b>: database utility class
 * 
 * An utility class that creates automatically a connection to a database
 * defined by the default in the class and/or configuration file.
 *
 * @abstract
 * @package nutshell
 * @subpackage data\db
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.1
 * @since 2012-10-31
 */
abstract class Database extends Clazz {
    
    const ERR_TABLE_MISSING = '42S02';
    const ERR_DUPLICATE_KEYS = '23000';
    const ERR_SQL_SYNTAX = '42000';

    /*
     * buona idea nel caso voglio estendere questa classe oppure implementare
     * un db_layer alternativo. In tal caso obbligo i parametri ad essere uguali
     * per tutti a partire da questa classe in giu
     *
     */
    const PARAM_BOOL = 'bool';
    const PARAM_NULL = 'null';
    const PARAM_INT = 'int';
    const PARAM_STR = 'string';
    const PARAM_SQL = 'sql';

    const SORT_ASC = 'ASC';
    const SORT_DESC = 'DESC';


    /**
     * Holds a connection of persistent connections to the database/s.
     * 
     * @var arrray An array of connection.
     */
    private static $_Connections = array();

    /**
     * Creates and returns a new database connection instance.
     * 
     * @param string $_connection A connection name.
     * @param string $_driver The driver to use.
     * @return IDatabaseConnection A database connection.
     */
    public static function connection($_connection, $_driver='nutshell\data\db\driver\pdo\PDOConnection') {
        if (!isset(self::$_Connections[$_connection . $_driver])) 
            self::$_Connections[$_connection . $_driver] = new $_driver(Configuration::at()->Mysql->$_connection->Hostname, 
                                                               Configuration::at()->Mysql->$_connection->Database, 
                                                               Configuration::at()->Mysql->$_connection->Username, 
                                                               Configuration::at()->Mysql->$_connection->Password);
        return self::$_Connections[$_connection . $_driver];
    }
    
    /**
     * @see Database::connection()
     */
    public static function on($_connection) {
        return self::connection($_connection);
    }
    
}
