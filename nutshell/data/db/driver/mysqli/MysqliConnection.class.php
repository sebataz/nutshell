<?php
namespace nutshell\data\db\driver\mysql;

use \mysqli;
use nutshell\data\db\IDatabaseConnection;
use nutshell\data\db\driver\DatabaseHalt;

/**
 * <b>MysqliConnection.clazz.php</b>: mysqli connection wrapper
 *
 * @package nutshell
 * @subpackage data\db\driver\mysqli
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
class MysqliConnection extends mysqli implements IDatabaseConnection {
    
    public function __construct($_hostname, $_database, $_username, $_password) {
        parent::__construct($_hostname, $_username, $_password, $_database);
        if ($this->connect_error) throw new DatabaseHalt('mysqli connection could not be opened');
    }
    
    public function query($_sql) {
        return parent::query($_sql);
    }
    
    public function newOperation() {
        return new MysqliOperation($this);
    }
}