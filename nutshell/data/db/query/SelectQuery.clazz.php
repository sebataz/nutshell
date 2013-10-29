<?php
namespace nutshell\data\db\query;

use nutshell\data\db\DatabaseOperation;
use nutshell\data\db\query\statement\PagedStatement;

/**
 * <b>SelectQuery.clazz.php</b>: select query
 * 
 * <p>The class creates a select query ready to be executed.</p>
 *
 * @package nutshell
 * @subpackage data\db\query
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-17
 */
class SelectQuery extends PagedStatement {
    
    /**
     * The table that will be queried.
     * 
     * @var string The table name.
     */
    protected $_table;
    
    /**
     * Sets the table name.
     * 
     * @param DatabaseOperation $_Operation A new operation.
     * @param string $_table A table name.
     */
    public function __construct(DatabaseOperation $_Operation, $_table) {
        parent::__construct($_Operation, '');
        $this->_table = $_table;
    }
    
    /**
     * Returns the table name that is to be queried.
     * 
     * @return string The table name.
     */
    public function getTable() {
        return $this->_table;
    }
    
    /**
     * Builds and return the query to be excuted.
     * 
     * @return string The built query.
     */
    public function getQuery() {
        $sql_query = 'SELECT * FROM ' . $this->_table;
        
        return $sql_query . parent::getQuery();
    }
}
