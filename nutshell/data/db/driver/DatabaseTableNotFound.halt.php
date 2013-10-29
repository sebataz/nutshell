<?php
namespace nutshell\data\db\driver;

/**
 * <b>DatabaseTableMissing.halt.php</b>: missing table halt
 * 
 * <p>Thrown when the database table does not exist.</p>
 *
 * @package nutshell
 * @subpackage data\db\driver
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
class DatabaseTableNotFound extends DatabaseHalt {

    /**
     * Sets the halt message.
     * 
     * @param string $_table The table name.
     */
    public function __construct($_table) {
        parent::__construct('database table not found ' . $_table);
    }
}