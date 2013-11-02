<?php
namespace nutshell\data\db\driver\mysql;

use nutshell\lang\Collection;
use nutshell\data\db\DatabaseOperation;

/**
 * <b>MysqlOperation.clazz.php</b>: mysql operation
 * 
 * @package nutshell
 * @subpackage data\db\driver\mysql
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
class MysqlOperation extends DatabaseOperation {
    
    public function execute() {
        return $this->_Connection->query($this->_Query->getQuery());
    }

    public function fetch() {
        $FetchedResult = new Collection();
        $mysql_resource = $this->execute();
        while ($row = mysql_fetch_array($mysql_resource, MYSQLI_ASSOC)) {
            $FetchedResult->add(new Collection($row));
        }
        
        return $FetchedResult;
    }
    
    /**
     * Escapes special characters in a string for use in an SQL statement.
     * 
     * @param type $_string
     * @return type
     */
    public function escapeString($_string) {
        return '"' . mysql_real_escape_string($_string) . '"';
    }
    
    /**
     * Get the ID generated in the last query.
     * 
     * @return mixed Last ID generated.
     */
    public function lastInsertID() {
        return mysql_insert_id();
    }
}
