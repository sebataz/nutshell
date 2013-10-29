<?php
namespace nutshell\data\db;

use nutshell\data\IDataSource;

/**
 * <b>IDatabaseConnection.interface.php</b>: database connection
 * 
 * <p>Instance of a database connection.</p>
 *
 * @package nutshell
 * @subpackage data\db\driver
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
interface IDatabaseConnection extends IDataSource {
    
    /**
     * Sends a query.
     * 
     * @param string $_query A query.
     * @return mixed A resource or a boolean value.
     * @throws QuerySqlError If query contains errors.
     */
    public function query($_sql);
    
    /**
     * Creates a new <kbd>DatabaseOperation</kbd> for this connection.
     * 
     * @return DatabaseOperation An new operation.
     */
    public function newOperation();
}
