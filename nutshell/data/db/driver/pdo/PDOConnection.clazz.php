<?php
namespace nutshell\data\db\driver\pdo;

use \PDO;
use \PDOException;
use nutshell\data\db\IDatabaseConnection;
use nutshell\data\db\Database;
use nutshell\data\db\driver\DatabaseHalt;
use nutshell\data\db\driver\DatabaseDuplicateKeys;
use nutshell\data\db\driver\QuerySqlError;

/**
 * <b>PDOConnection.clazz.php</b>: PDO database connection
 * 
 * <p>A database connection based on the php's PDO driver.</p>
 * 
 * @package nutshell
 * @subpackage data\db\driver\pdo
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
class PDOConnection extends PDO implements IDatabaseConnection {
    
    /**
     * Sets the database connection string and opens a database connection through
     * the PDO driver.
     * 
     * @param string $_hostname Database hostname.
     * @param string $_database Database name.
     * @param string $_username Database access username.
     * @param string $_password Database access password.
     * @param string $_driver Database type
     * @throws DatabaseHalt Thrown if on connection failure.
     */
    public function __construct($_hostname, $_database, $_username, $_password, $_driver = 'mysql') {
        try {
            parent::__construct("$_driver:host=$_hostname;dbname=$_database",$_username,$_password);

            /*
             * PDO::ERRMODE_SILENT
             *  This is the default mode. PDO will simply set
             *  the error code for you to inspect using the PDO::errorCode() and
             *  PDO::errorInfo() methods on both the statement and database
             *  objects; if the error resulted from a call on a statement
             *  object, you would invoke the PDOStatement::errorCode() or
             *  PDOStatement::errorInfo() method on that object. If the error
             *  resulted from a call on the database object, you would invoke
             *  those methods on the database object instead.
             *
             * PDO::ERRMODE_WARNING
             *  In addition to setting the error code, PDO will emit a
             *  traditional E_WARNING message. This setting is useful during
             *  debugging/testing, if you just want to see what problems
             *  occurred without interrupting the flow of the application.
             */
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            //$this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('Statement'));
            //$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        } catch (PDOException $E) {
            throw new DatabaseHalt($E->getMessage());
        }
    }


    /**
     * Executes a SQL query.
     * 
     * @param string $_sql An SQL query to execute.
     * @throws DatabaseTableNotFound Thrown if datatabase table does not exist.
     * @throws DatabaseDuplicateKeys Thrown if trying to inser a duplicate key.
     * @throws QuerySqlError Thrown on sql errors.
     * @throws DatabaseHalt Thrown on database failure.
     */
    public function query($_sql) {
        // execute string
        if (false===($this->exec($_sql))) {
            
            // check if any error
            switch ($this->errorCode()) {
                case Database::ERR_TABLE_MISSING:
                    throw new DatabaseTableNotFound(implode(', ', preg_replace("/^.*Table \'(.*)\' doesn.*$/", '$1', $this->errorInfo())));

                case Database::ERR_DUPLICATE_KEYS:
                    throw new DatabaseDuplicateKeys(implode(', ', $this->errorInfo()));
                    
                case Database::ERR_SQL_SYNTAX:
                    throw new QuerySqlError($_sql);

                default:
                    throw new DatabaseHalt(implode(', ', $this->errorInfo()));
            }
        }
    }
    
    /**
     * Returns a new operation for this connection.
     * 
     * @return PDOOperation A new PDO operation.
     */
    public function newOperation() {
        return new PDOOperation($this);
    }
}