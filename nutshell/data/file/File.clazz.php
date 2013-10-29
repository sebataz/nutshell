<?php
namespace nutshell\data\file;

use nutshell\lang\Object;
use nutshell\lang\ArrayMap;
use nutshell\data\IDataSource;

/**
 * <b>File.clazz.php</b>: file stream handler
 * 
 * <p>Opens a file from the filesystem for read and write operations.<p>
 * 
 * @abstract
 * @package nutshell
 * @subpackage data\file
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
abstract class File extends Object implements IDataSource {
    
    
    /**
     * A file pointer resource.
     * 
     * @var mixed A file pointer.
     */
    protected $_handle;
    
    /**
     * The path to the directory holding the file.
     * 
     * @var string Path to file.
     */
    protected $_pathToFile;
    
    /**
     * The name of the file.
     * 
     * @var string File name.
     */
    protected $_filename;


    /**
     * Creates a file object for the path defined by <var>$_path_to_file</var>.
     * 
     * @param string $_path_to_file Path to file.
     * @throws FileNotFound Thrown when file is not found.
     */
    public function __construct($_path_to_file) {
        if (!file_exists($_path_to_file))
            throw new FileNotFound($_path_to_file);
        
        $this->_pathToFile = dirname($_path_to_file);
        $this->_filename = basename($_path_to_file);
    }

    /**
     * Opens a file and creates a file pointer resource in mode defined by 
     * <var>$_mode</var>.
     * 
     * @param string $_mode Open mode.
     * @throws CannotOpenFile Thrown if file cannot be opened.
     */
    protected function __open($_mode) {
        if (null == ($this->_handle = @fopen($this->_pathToFile . DS . $this->_filename, $_mode)))
            throw new CannotOpenFile('cannot open file ' . $this->_pathToFile . DS . $this->_filename);
    }
    
    /**
     * Closes a file and its relative file pointer resource.
     */
    protected function __close() {
        fclose($this->_handle);
    }

    /**
     * Returns the content of a directory.
     * 
     * @param string $_path_to_dir Path to directory.
     * @param bool $_list_all If <b>TRUE</b> returns everything, otherwise only
     *                        the visible files.
     * @return ArrayMap Array map of directory entries (files).
     * @throws FileNotFound Thrown if directory is not found.
     */
    public static function ls($_path_to_dir, $_list_all=false) {
        //check if dir exist
        if (!file_exists($_path_to_dir)) 
            throw new FileNotFound($_path_to_dir);
        
        // open dir
        $handle = opendir($_path_to_dir);
        $List = new ArrayMap();

        // read dir
        while (false != ($file = readdir($handle))) {
            // if $_all == false all the file starting with a dot will be omitted
            if (($_list_all == false) && (preg_match('/^[\.].*/', $file))) continue;
            
            $List->add($file);
        }

        // close dir
        closedir($handle);
        return $List;
    }
}