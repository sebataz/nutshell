<?php
namespace nutshell\model\db;

use nutshell\lang\ArrayMap;
use nutshell\lang\halt\PropertyNotFound;
use nutshell\data\db\DatabaseOperation;
use nutshell\data\db\query\JointQuery;

/**
 * <b>DbFinder.clazz.php</b>: model finder for database
 * 
 * <p>The finder will send a select query to the database connection and will
 * create a collection of models, organized as defined in model classes.</p>
 * 
 * <p>This class extends a <kbd>JointQuery</kbd> so that you can relate two or
 * more models between them.</p>
 *
 * @package nutshell
 * @subpackage model\db
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-07-11
 */
class DbFinder extends JointQuery {
    
    /**
     * The model name, which is the same as the table name.
     *
     * @var string The model name.
     */
    protected $_model;
    
    /**
     * Holds the name of the joined model.
     *
     * @var ArrayMap A collection of joined model.
     */
    protected $_JointModel;
    
    /**
     * Creates an instance of a <kbd>JointQuery</kbd> specialized for models.
     * 
     * @param DatabaseOperation $_Operation A new database operation.
     * @param string $_model The model name.
     */
    public function __construct(DatabaseOperation $_Operation, $_model) {
        parent::__construct($_Operation, $_model::getClazz());
        $this->_model = $_model;
        $this->_JointModel = new ArrayMap();
    }
    
    /**
     * @see JointQuery::join()
     */
    public function join($_model) {
        parent::join($_model::getClazz(true));
        $this->_JointModel->add($_model::getClazz(true), $_model);
    }
    
    /**
     * Create and returns a collection of models.
     * 
     * @return ArrayMap A collection of models.
     */
    public function toCollection() {
        $Collection = new ArrayMap();
        $table = $this->_table;
        $model = $this->_model;
        
        
        foreach ($this->send() as $Entry) {
            if (!$Collection->keyExists($Entry->get($table))) {
                $Model = new $model();
                $Model->Map($Entry);
                $Collection->add($Entry->get($table), $Model);
            
            // if the table id is already set this mean that the following will
            // be a new entry to add to the model and not replace it
            } else {
                foreach ($this->_JoinTable as $joint) {
                    try {
                        $joint_model = $this->_JointModel->get($joint);
                        $Joint = new $joint_model();
                        $Joint->Map($Entry);
                        
                        $Collection->get($Entry->get($table))->callback('add' . $joint, $Joint);
                    } catch (PropertyNotFound $H) {
                        continue;
                    }
                }
            }
        }
        
        return $Collection;
    }
}
