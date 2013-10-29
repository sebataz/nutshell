<?php
namespace nutshell\data\db\query;

use nutshell\lang\ArrayMap;
use nutshell\data\db\DatabaseOperation;
use nutshell\data\db\query\statement\PreparedStatement;

/**
 * <b>InsertQuery.clazz.php</b>: insert query
 * 
 * <p>The class creates an insert query ready to be executed.</p>
 *
 * @package nutshell
 * @subpackage data\db\query
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-17
 */
class InsertQuery extends PreparedStatement {
    
    /**
     * Builds and sets the query to be executed.
     * 
     * @param DatabaseOperation $_Operation A new database operation.
     * @param string $_table The table name.
     * @param ArrayMap $_Values A collection of column and value to insert.
     */
    public function __construct(DatabaseOperation $_Operation, $_table, ArrayMap $_Values) {
        parent::__construct($_Operation, 'INSERT INTO ' . $_table
                          . ' (' . implode(', ', $_Values->getKeys()) . ')'
                          . ' VALUES (:' . implode(', :', $_Values->getKeys()) . ')');
    }
}
