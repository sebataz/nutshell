<?php
namespace nutshell\data\db;

use nutshell\lang\Object;
use nutshell\lang\ArrayMap;
use nutshell\data\db\query\SelectQuery;
use nutshell\data\db\query\InsertQuery;
use nutshell\data\db\query\UpdateQuery;
use nutshell\data\db\query\DeleteQuery;

/**
 * <b>QueryBuilder.clazz.php</b>: query builder
 * 
 * <p>The class returns a query ready to be executed.</p>
 *
 * @package nutshell
 * @subpackage data\db
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-17
 */
class QueryBuilder extends Object {
    
    /**
     * The database connection on which all queries are done.
     * 
     * @var IDatabaseConnection Connection to database.
     */
    private $_Connection;
    
    /**
     * Sets the database connection.
     * 
     * @param IDatabaseConnection $_Connection Connection to database.
     */
    public function __construct(IDatabaseConnection $_Connection) {
        $this->_Connection = $_Connection;
    }
    
    /**
     * Creates a new SelectQuery for the table defined by <var>$_table</var>.
     * 
     * @param string $_table The table name.
     * @return SelectQuery A <kbd>SelectQuery</kbd>.
     */
    public function select($_table) {
        return new SelectQuery($this->_Connection->newOperation(), $_table);
    }
    
    /**
     * Creates a new InsertQuery for the table defined by <var>$_table</var>.
     * 
     * @param string $_table The table name.
     * @param ArrayMap $_Values Row's value to insert.
     * @return InsertQuery A <kbd>InsertQuery</kbd>.
     */
    public function insert($_table, ArrayMap $_Values) {
        $Insert = new InsertQuery($this->_Connection->newOperation(), $_table, $_Values);
        
        foreach ($_Values as $key => $value)
            $Insert->addParameter ($key, $value);
        
        return $Insert;
    }
    
    /**
     * Creates a new UpdateQuery for the table defined by <var>$_table</var>.
     * 
     * @param string $_table The table name.
     * @param ArrayMap $_Values Row's values to update.
     * @return UpdateQuery A <kbd>UpdateQuery</kbd>.
     */
    public function update($_table, ArrayMap $_Values) {
        $Update = new UpdateQuery($this->_Connection->newOperation(), $_table, $_Values);
        
        foreach ($_Values as $key => $value)
            $Update->addParameter ($key, $value);
        
        return $Update;
    }
    
    /**
     * Creates a new DeleteQuery for the table defined by <var>$_table</var>.
     * 
     * @param string $_table The table name.
     * @return DeleteQuery A <kbd>DeleteQuery</kbd>.
     */
    public function delete($_table) {
        return new DeleteQuery($this->_Connection->newOperation(), $_table);
    }
}
