<?php
namespace nutshell\data\db;

use nutshell\lang\Clazz;
use nutshell\lang\Collection;

/**
 * <b>DatabaseOperation.clazz.php</b>: database operation
 * 
 * <p>A database operation offers some basic method to query a database. Mainly,
 * each operation aim is to perform a query.</p>
 * 
 * (Multiple queries not yet implemented)
 *
 * @abstract
 * @package nutshell
 * @subpackage data\db\query
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
abstract class DatabaseOperation extends Clazz {
    
    /**
     * The database connection on which all queries are done.
     * 
     * @var IDatabaseConnection Connection to database.
     */
    protected $_Connection;
    
    /**
     * Textual query to be sent to a database.
     * 
     * @var string A query.
     */
    protected $_query;

    /**
     * Sets the operations's connection.
     * 
     * @param IDatabaseConnection $_Connection A database connection.
     */
    public function __construct(IDatabaseConnection $_Connection) {
        $this->_Connection = $_Connection;
    }

    /**
     * Sets a query to be excuted on this connection.
     * 
     * @param string $_query A query.
     */
    public function setQuery($_query) {
        $this->_query = $_query;
    }
    
    /**
     * Creates a new database table defined as <var>$_table_name</var> with the
     * columns definition in <var>$_Column</var>.
     * 
     * @param string $_table_name The table name.
     * @param Collection $_Column The table's column definition.
     * @return mixed A boolean value.
     */
    public function createTable($_table_name, Collection $_Column) {
        $ColumnDefinition = new Collection();
        foreach ($_Column as $column => $type) {
            $ColumnDefinition->add($column . ' ' . $type);
        }
            
        return $this->_Connection->query('CREATE TABLE IF NOT EXISTS ' . $_table_name 
                          . ' (' . implode(', ', $ColumnDefinition->toArray()) 
                          . ') ENGINE=InnoDB');
    }
    
    /**
     * Drops (delete) a table if it exists.
     * 
     * @param string $_table_name A table name.
     */
    public function dropTable($_table_name) {
        $this->_Connection->query('DROP TABLE IF EXISTS ' . $_table_name);
    }
    
    /**
     * Truncates (empty) a table.
     * 
     * @param string $_table_name A table name.
     */
    public function emptyTable($_table_name) {
        $this->_Connection->query('TRUNCATE TABLE ' . $_table_name);
    }
    
    /**
     * Returns the rows count for a table.
     * 
     * @param string $_table_name A table name.
     */
    public function countTable($_table_name) {
        $this->_Connection->query('SELECT COUNT(*) AS Count FROM ' . $_table_name);
    }
    
    /**
     * Escapes special characters in a string for use in an SQL statement.
     * 
     * @param string $_string A string to escape.
     * @return string An escaped string.
     */
    abstract public function escapeString($_string);
    
    /**
     * Get the ID generated in the last query.
     * 
     * @return mixed Last ID generated.
     */
    abstract public function lastInsertID();

    /**
     * Executes the query. Throws an halt if the execution fails.
     */
    abstract public function execute();
    
    /**
     * Executes the query and returns the fetched data into a collection.
     * 
     * @return Collection A collection of rows.
     */
    abstract public function fetch();
}