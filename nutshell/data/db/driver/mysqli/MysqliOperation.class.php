<?php
namespace nutshell\data\db\driver\mysqli;

use nutshell\data\db\DatabaseOperation;
use nutshell\data\db\query\statement\SQLQuery;

/**
 * <b>MysqliOperation.clazz.php</b>: mysqli operation
 * 
 * @package nutshell
 * @subpackage data\db\driver\mysqli
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
class MysqliOperation extends DatabaseOperation {
    
    protected $_Statement;
    
    public function query(SQLQuery $_Query) {
        $this->_Statement = $this->_Connection->prepare($_Query->getQuery());
    }

    public function escapeString($_string) {
        return mysqli_real_escape_string($this, $_string);
    }

    public function lastInsertID() {
        return mysqli_insert_id($this);
    }
    
    public function execute() {
    }

    public function fetch() {
    }
}