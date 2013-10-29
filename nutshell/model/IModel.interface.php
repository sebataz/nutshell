<?php
namespace nutshell\model;

use nutshell\data\IDataSource;

/**
 * <b>IModel.interface.php</b>: model interface
 *
 * @package nutshell
 * @subpackage model
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-07-11
 */
interface IModel {
    
    /**
     * Register a model to its relative data source.
     * 
     * @param IDataSource $_DataSource
     */
    public static function register(IDataSource $_DataSource);
    
    /**
     * Returns a collection of model instances.
     * 
     * @return ArrayMap A collection of models.
     */
    public static function find();
    
    /**
     * Saves the current object values to memory support.
     */
    public function save();
    
    /**
     * Removes the current object from the memory support.
     */
    public function remove();
}
