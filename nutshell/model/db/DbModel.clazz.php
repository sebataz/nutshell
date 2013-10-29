<?php
namespace nutshell\model\db;

use nutshell\lang\ArrayMap;
use nutshell\lang\halt\Halt;
use nutshell\data\IDataSource;
use nutshell\data\db\QueryBuilder;
use nutshell\model\Model;

/**
 * <b>DbModel.clazz.php</b>: data manipulation methods
 * 
 * <p>The <kbd>DbModel</kbd> implements the methods to manipulate data for a model
 * that are memorized inside a database. The class is responsible to create
 * and send the queries for data to the database.</p>
 *
 * @package nutshell
 * @subpackage model\db
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-07-11
 */
abstract class DbModel extends Model {
    
    /**
     * Holds a query builder instance to generate the model queries.
     *
     * @var QueryBuilder A query builder instance.
     */
    private static $_QueryBuilder;
    
    /**
     * Holds the database connection to send queries.
     *
     * @var IDatabaseConnection The database connection.
     */
    private static $_Connection;
    
    /**
     * Sets a database connection for the model and creates and binds the model
     * to a database table, if the table does not exists tries to create it.
     * 
     * @param IDataSource $_Connection A database connection.
     */
    public static function register(IDataSource $_Connection) {
        
        // create query builder
        self::$_QueryBuilder = new QueryBuilder($_Connection);
        self::$_Connection = $_Connection;
        
        // define table columns and type
        $Column = new ArrayMap();
        $Column->add(self::getClazz(), 'INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY');
        
        foreach (self::getClazzProperties()->getKeys() as $property) {
            $Column->add($property, constant(self::getClazz(true) . '::' . $property));
        }
          
        // create table if not exist
        self::$_Connection->newOperation()->createTable(self::getClazz(), $Column);
        
    }
    
    /**
     * @see IModel::find()
     * @throws Halt Thrown if database connection is null.
     */
    public static function find() {
        if (null === self::$_Connection) throw new Halt('model data source cannot be null');
        return new DbFinder(self::$_Connection->newOperation(), self::getClazz(true));
    }
    
    /**
     * @see IModel::save()
     */
    public function save() {
        $Column = new ArrayMap();
        
        // get model properties
        foreach ($this->getObjectProperties() as $property => $value) {
            $Column->add($property, $value instanceof Model?$value->getID():$value);
        }
        
        
        if (null === $this->getID()) {
            // insert new row
            $Insert = self::$_QueryBuilder->insert($this->getClazz(), $Column);
            $Insert->send();
            
            // set created id for model
            $this->setID(self::$_Connection->lastInsertID());
            
        } else {
            // update row
            $Update = self::$_QueryBuilder->update($this->getClazz(), $Column);
            $Update->where(self::getClazz() . '=' . $this->getID());
            $Update->send();
        }
    }
    
    /**
     * @see IModel::remove()
     */
    public function remove() {
        $Delete = self::$_QueryBuilder
                ->delete(self::getClazz())
                ->where($this->getClazz() . '=' . $this->getID())->send();
    }
}
