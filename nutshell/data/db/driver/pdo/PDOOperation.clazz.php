<?php
namespace nutshell\data\db\driver\pdo;

use \PDO as PDO;
use nutshell\lang\ArrayMap;
use nutshell\lang\Map;
use nutshell\data\db\DatabaseOperation;
use nutshell\data\db\Database;
use nutshell\data\db\driver\DatabaseHalt;
use nutshell\data\db\driver\DatabaseDuplicateKeys;
use nutshell\data\db\driver\QuerySqlError;

/**
 * <b>PDOOperation.clazz.php</b>: PDO database operation
 * 
 * <p>The PDO operation uses the <kbd>PDOStatement</kbd> class to perform queries.</p>
 *
 * @package nutshell
 * @subpackage data\db\driver\pdo
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
class PDOOperation extends DatabaseOperation {
    
    /**
     * Holds the a PDO statement prepared by the PDO connection.
     *
     * @var PDOStatement A PDO statement.
     */
    protected $_Statement = null;

    /**
     * Sets the query and prepares a new statement for the query.
     * 
     * @param string $_query An sql query.
     */
    public function setQuery($_query) {
        parent::setQuery($_query);
        $this->_Statement = $this->_Connection->prepare($_query);
    }

    /**
     * @see DatabaseOperation::escapeString()
     */
    public function escapeString($_string) {
        return $this->_Connection->quote($_string);
    }
    
    /**
     * @see DatabaseOperation::lastInsertID()
     */
    public function lastInsertID() {
        return $this->_Connection->lastInsertId();
    }

    /**
     * @see DatabaseOperation::execute()
     * @throws DatabaseTableNotFound Thrown if database table does not exist.
     * @throws DatabaseDuplicateKeys Thrown if trying to insert a duplicate key.
     * @throws QuerySqlError Thrown on sql errors.
     * @throws DatabaseHalt Thrown on database operation fail.
     */
    public function execute() {

        if (false===($this->_Statement->execute())) {
            switch ($this->_Statement->errorCode()) {
                case Database::ERR_TABLE_MISSING:
                    throw new DatabaseTableNotFound(implode(', ', preg_replace("/^.*Table \'(.*)\' doesn.*$/", '$1', $this->_Statement->errorInfo())));

                case Database::ERR_DUPLICATE_KEYS:
                    throw new DatabaseDuplicateKeys(implode(', ', $this->_Statement->errorInfo()));
                    
                case Database::ERR_SQL_SYNTAX:
                    throw new QuerySqlError($this->_Statement->queryString);

                default:
                    throw new DatabaseHalt(implode(', ', $this->_Statement->errorInfo()));
            }
        }
    }

    /**
     * @see DatabaseOperation::fetch()
     */
    public function fetch() {
        // execute statement
        $this->execute();

        // create collection of rows
        $FetchedResult = new ArrayMap();
        foreach ($this->_Statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            if ($row!=null) {
               $FetchedResult->add(new Map($row));
            }
            
            
        }
        
        return $FetchedResult;
    }
}