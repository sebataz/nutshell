<?php
namespace nutshell\data\db\driver;

/**
 *  <b>SqlErrorHalt.halt.php</b>: sql error halt
 * 
 * <p>Thrown when the query contains errors.</p>
 *
 * @package nutshell
 * @subpackage data\db\driver
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-16
 */
class QuerySqlError extends DatabaseHalt {
    
    /**
     * Sets the halt message.
     * 
     * @param string $_query Erroneous query.
     */
    public function __construct($_query) {
        parent::__construct('SQL syntax error in "' . $_query . '"');
    }
}
