<?php
namespace nutshell\data\file;

use nutshell\lang\halt\Halt;

/**
 * <b>FileNotFound.clazz.php</b>: file not found halt
 * 
 * <p>Thrown when file identified by <var>$_path_to_file</var> does not exist.</p>
 *
 * @package nutshell
 * @subpackage data\file
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @since 2013-06-19
 * @version 0.0
 */
class FileNotFound extends Halt {
    
    /**
     * Sets the halt message.
     * 
     * @param string $_path_to_file Path to file.
     */
    public function __construct($_path_to_file) {
        parent::__construct('file not found ' . $_path_to_file);
    }
}
