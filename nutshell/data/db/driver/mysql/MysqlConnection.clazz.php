<?php
namespace nutshell\data\db\driver\mysql;

use nutshell\lang\Object;
use nutshell\data\db\IDatabaseConnection;
use nutshell\data\db\driver\DatabaseConnectionFail;
use nutshell\data\db\driver\QuerySqlError;

/**
 * <b>MysqlConnection.clazz.php</b>: mysql connection
 * 
 * @package nutshell
 * @subpackage data\db\driver\mysql
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
class MysqlConnection extends Object implements IDatabaseConnection {
    
    /**
     * MySQL link identifier to database connection.
     * 
     * @var resource MySQL link identifier.
     */
    protected $_handle = null;
    
    /**
     * Open a new connection to a MySQL database and creats a link identifier in
     * <var>$_handle</var>.
     * 
     * @param string $_hostname MySQL server hostname.
     * @param string $_database MySQL database name.
     * @param string $_username MySQL access username.
     * @param string $_password MySQL access password.
     * @throws DatabaseConnectionFail If connection fails.
     * @throws DatabaseNotFound If database is not found.
     */
    public function __construct($_hostname, $_database, $_username, $_password) {
        /*** Opening connection to database ***/
        if (null == ($this->_handle = @mysql_connect($_hostname, $_username, $_password, true)))
            throw new DatabaseConnectionFail($_username, $_password, $_hostname);
        
        /*** Selecting database ***/
        if (!@mysql_select_db($_database, $this->_handle))
            throw new DatabaseNotFound($_database);
    }

    /**
     * Closes a MySQL connection and unsed link identifier.
     * 
     * @throws DatabaseHalt If cannot close connection.
     */
    public function close() {
        /*** Closing connection to database ***/
        if (mysql_close($this->_handle)) 
            $this->_handle = null;
        else 
            throw new DatabaseHalt('can\'t close db' . (string)$this->_handle);
    }
    
    /**
     * Sends a MySQL query.
     * 
     * @param string $_query A query.
     * @return mixed A resource or a boolean value.
     * @throws QuerySqlError If query contains errors.
     */
    public function query($_query) {
        $result = @mysql_query($_query, $this->_handle);
        
        if (mysql_errno($this->_handle))
            throw new QuerySqlError($_query);
        
        return $result;
    }
    
    
    
    /**
     * Creates a new <kbd>DatabaseOperation</kbd> for this connection.
     * 
     * @return MysqlOperation A MySQL operation.
     */
    public function newOperation() {
        return new MysqlOperation($this);
    }
}