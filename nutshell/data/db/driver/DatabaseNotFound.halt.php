<?php
namespace nutshell\data\db\driver;

/**
 * <b>DatabaseNotFound.halt.php</b>: database not found halt
 * 
 * <p>Thrown when the database does not exist.</p>
 *
 * @package nutshell
 * @subpackage data\db\driver
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
class DatabaseNotFound extends DatabaseHalt {

    /**
     * Sets the halt message.
     * 
     * @param string $_database The database name.
     */
    public function __construct($_database) {
        parent::__construct('database not found ' . $_database);
    }
}
