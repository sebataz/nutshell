<?php
namespace nutshell\data\file;

/**
 * <b>FileOutput.clazz.php</b>: file writer
 * 
 * Opens a file from the filesystem for write operations.
 *
 * @package nutshell
 * @subpackage data\file
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
class FileWrite extends File {
    
    /**
     * Opens and write to a file, old content (if any) will be overwritten.
     * 
     * @param string $_content Data to write.
     * @return mixed The number of bytes written, or FALSE on error. 
     */
    public function write($_content) {
        // opens file
        $this->__open('w');
        
        // writes content to file
        $result = fwrite($this->_handle, $_content);
        
        // closes file
        $this->__close();

        return $result;
    }
    
    /**
     * Opens and write to file in append mode, new content will be added at the
     * end of the file.
     * 
     * @param string $_content Data to write.
     * @return mixed The number of bytes written, or FALSE on error. 
     */
    public function append($_content) {
        // opens file
        $this->__open('a');
        
        // append content to file
        $result = fwrite($this->_handle, $_content . "\n");
        
        // closes file
        $this->__close();

        return $result;
    }
}