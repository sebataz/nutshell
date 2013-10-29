<?php
namespace nutshell\data\file;

/**
 * <b>FileInput.clazz.php</b>: file reader
 * 
 * Opens a file from the filesystem for read operations.
 *
 * @package nutshell
 * @subpackage data\file
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
class FileRead extends File {
    
    /**
     * Reads a file and return its content into a string.
     * 
     * @param int $_length Lenght of file to be read. If not specified reads entire file.
     * @return string Content of file.
     */
    public function read($_length=null) {
        // check size of file if lenght not specified
        $_length = isset($_length) ? $_length : filesize($this->_pathToFile . DS . $this->_filename);

        // opens file
        $this->__open('r');
        
        // reads file
        $file = fread($this->_handle, $_length);
        
        // close file
        $this->__close();

        return $file;
    }

    /**
     * Reads a file and return its content into an array of strings, in which
     * every element of the array is a line of the file.
     * 
     * @param int $_length Lenght of file to be read. If not specified reads entire file.
     * @return array Array of lines.
     */
    public function lineByLine($_length=null) {
        return explode("\n", $this->read($_length));
    }
}