<?php
namespace nutshell\data\file;

use nutshell\lang\halt\Halt;

/**
 * <b>CannotOpenFile.halt.php</b>: cannot open file halt
 * 
 * <p>Thrown when file is cannot be opened.</p>
 *
 * @package nutshell
 * @subpackage data\file
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @since 2013-06-19
 * @version 0.0
 */
class CannotOpenFile extends Halt {
    
    /**
     * Sets the halt message
     * 
     * @param string $_path_to_file Path to file.
     */
    public function __construct($_path_to_file) {
        parent::__construct('cannot open file ' . $_path_to_file);
    }
}
