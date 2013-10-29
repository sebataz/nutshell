<?php
namespace nutshell\data\db\query;

use nutshell\data\db\DatabaseOperation;
use nutshell\data\db\query\statement\PagedStatement;

/**
 * <b>DeleteQuery.clazz.php</b>: delete query
 * 
 * <p>The class creates an delete query ready to be executed.</p>
 *
 * @package nutshell
 * @subpackage data\db\query
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-17
 */
class DeleteQuery extends PagedStatement {
    
    /**
     * Builds and sets the delete query to be executed.
     * 
     * @param DatabaseOperation $_Operation A new database operation.
     * @param string $_table A table name.
     */
    public function __construct(DatabaseOperation $_Operation, $_table) {
        parent::__construct($_Operation, 'DELETE FROM ' . $_table);
    }
}
