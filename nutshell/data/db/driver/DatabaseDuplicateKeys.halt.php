<?php
namespace nutshell\data\db\driver;

/**
 * <b>DatabaseDuplicateKeys.halt.php</b>: duplicate keys halt
 * 
 * <p>Thrown when attempting to create a primary key already existing in the 
 * database.</p>
 *
 * @package nutshell
 * @subpackage data\db\driver
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2010-06-14
 */
class DatabaseDuplicateKeys extends DatabaseHalt {
}