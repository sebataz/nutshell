<?php
namespace nutshell\data\db\query;

use nutshell\lang\ArrayMap;
use nutshell\data\db\DatabaseOperation;
use nutshell\data\db\query\statement\PagedStatement;

/**
 * <b>JointQuery.clazz.php</b>: joined tables query
 * 
 * <p>The class creates a select query with joined tables ready to be executed.
 * The query uses the <kbd>NATURAL JOIN</kbd> clause in order to join the
 * tables. It assumes that the joining table each contain a column with the same
 * name, the <kbd>NATURAL JOIN</kbd> will return all those rows which have
 * the same value on the same name column.</p>
 * 
 * <p>Example: <br />
 * $JointQuery = new JointQuery('RootTable')->join('JointTable');
 * 
 * is same as:
 * 
 * mysql> SELECT * FROM RootTable;
 * +------------+------------+
 * | PrimaryKey | ForeignKey |
 * +------------+------------+
 * |          1 |          1 |
 * |          2 |          2 |
 * +------------+------------+
 * 2 rows in set (0.00 sec)
 * 
 * mysql> SELECT * FROM JointTable;
 * +------------+-----------------+
 * | ForeignKey | SomeInformation |
 * +------------+-----------------+
 * |          1 | Information A   |
 * |          2 | Information B   |
 * +------------+-----------------+
 * 2 rows in set (0.00 sec)
 * 
 * mysql> SELECT * FROM RootTable NATURAL JOIN JointTable;
 * +------------+------------+-----------------+
 * | ForeignKey | PrimaryKey | SomeInformation |
 * +------------+------------+-----------------+
 * |          1 |          1 | Information A   |
 * |          2 |          2 | Information B   |
 * +------------+------------+-----------------+
 * 2 rows in set (0.00 sec)
 * </p>
 *
 * @package nutshell
 * @subpackage data\db\query
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-17
 */
class JointQuery extends PagedStatement {
    
    /**
     * The name of the root table that will be queried.
     * 
     * @var string The table name.
     */
    protected $_table;
    
    /**
     * Collection of table names to be joined in the query.
     * 
     * @var ArrayMap The joined table names.
     */
    protected $_JoinTable;
    
    /**
     * Creates a joint query and sets a new operation and the table name.
     * 
     * @param DatabaseOperation $_Operation A new operation.
     * @param type $_table The table name.
     */
    public function __construct(DatabaseOperation $_Operation, $_table) {
        parent::__construct($_Operation, '');
        $this->_table = $_table;
        $this->_JoinTable = new ArrayMap();
    }
    
    /**
     * Returns the table name for the query.
     * 
     * @return string A table name.
     */
    public function getTable() {
        return $this->_table;
    }
    
    /**
     * Returns the name of the joined table in the query.
     * 
     * @return ArrayMap Collection of table names.
     */
    public function getJoinTable() {
        return $this->_JoinTable;
    }
    
    /**
     * Sets a new table to join in the query. Join of table is done with
     * the <kbd>NATURAL JOIN</kbd> clause.
     * 
     * @param string $_table
     * @return JointQuery This query.
     */
    public function join($_table) {
        $this->_JoinTable->add($_table);
        return $this;
    }
    
    /**
     * Builds and return the query ready to be executed.
     * 
     * @return string A built query.
     */
    public function getQuery() {
        // set root table name
        $sql_query = 'SELECT * FROM ' . $this->_table;
        
        // set joined table names
        foreach ($this->_JoinTable as $table) 
            $sql_query .= ' NATURAL JOIN ' . $table;
        
        // build query
        return $sql_query . parent::getQuery();
    }
}
