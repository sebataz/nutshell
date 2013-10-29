<?php
namespace nutshell\data\db\query;

use nutshell\lang\ArrayMap;
use nutshell\data\db\DatabaseOperation;
use nutshell\data\db\query\statement\PagedStatement;

/**
 * <b>UpdateQuery.clazz.php</b>: update query
 * 
 * <p>The class creates an update query ready to be executed.</p>
 *
 * @package nutshell
 * @subpackage data\db\query
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-17
 */
class UpdateQuery extends PagedStatement {
    
    /**
     * Builds and sets the update query.
     * 
     * @param DatabaseOperation $_Operation A new database operation.
     * @param string $_table The table name
     * @param ArrayMap $_Values Columns and value to update.
     */
    public function __construct(DatabaseOperation $_Operation, $_table, ArrayMap $_Values) {
        // set the table name
        $sql_query = 'UPDATE ' . $_table . ' SET ';
        
        // set the values per column
        foreach ($_Values->getKeys() as $key)
            $field[] = $key . '=:' . $key;
        
        // build the query
        $sql_query .= implode(', ', $field);
        parent::__construct($_Operation, $sql_query);
    }
}
