<?php
namespace nutshell\data\db\driver;

/**
 * <b>DatabaseConnectionFail.halt.php</b>: database connection failed
 * 
 * <p>Thrown when a connection to a database fails to open.</p>
 *
 * @package nutshell
 * @subpackage data\db\driver
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
class DatabaseConnectionFail extends DatabaseHalt {
    
    /**
     * Sets the halt message.
     * 
     * @param string $_username Database access username.
     * @param string $_password Database access password.
     * @param string $_hostname Database name.
     */
    public function __construct($_username, $_password, $_hostname) {
        parent::__construct('connection to database failed with ' . $_username . ':' . $_password . '@' . $_hostname);
    }
}
