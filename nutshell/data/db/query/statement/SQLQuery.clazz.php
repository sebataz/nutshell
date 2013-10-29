<?php
namespace nutshell\data\db\query\statement;

use nutshell\lang\Object;
use nutshell\data\db\DatabaseOperation;

/**
 * <b>SQLQuery.clazz.php</b>: SQL query
 * 
 * <p>A wrapper for any query to be sent to a database through its open connection.
 * Note that the query is sent to an operation first, which knows the database
 * connection thus allowing to query the database.</p>
 *
 * @package nutshell
 * @subpackage data\db\query\statement
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-17
 */
class SQLQuery extends Object {
    
    /**
     * A database operation on which to execute the query.
     * 
     * @var DatabaseOperation A database operation.
     */
    protected $_Operation;
    
    /**
     * The textual query to be sent to the database.
     * 
     * @var string A query.
     */
    private $_sqlQuery;
    
    /**
     * Sets a new operation and the textual query for this SQL query.
     * 
     * @param DatabaseOperation $_Operation A database operation.
     * @param string $_sql_query A query.
     */
    public function __construct(DatabaseOperation $_Operation, $_sql_query) {
        $this->_Operation = $_Operation;
        $this->_sqlQuery = $_sql_query;
    }
    
    /**
     * Returns the textual query ready to be executed.
     * 
     * @return string A query
     */
    public function getQuery() {
        return $this->_sqlQuery;
    }
    
    /**
     * @see SQLQuery::getQuery()
     */
    public function __toString() {
        return $this->getQuery();
    }
    
    /**
     * Send a query to be executed to the database. Can return a collection of data
     * or a boolean value.
     * 
     * @return mixed A collection of data or a boolean value.
     */
    public function send() {
        //set operation query
        $this->_Operation->setQuery($this->getQuery());
        //excute query
        return $this->_Operation->fetch();
    }
}
