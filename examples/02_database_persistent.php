<?php
/**
 * Nutshell Example: database with configuraion
 * 
 * You can access a singleton instance of a database connection directly. The call
 * will open a connection if necessary otherwise return the already open connection
 */

// Nutshell autoloader
include '../nutshell/Nutshell.autoloader.php'; 

/*
 * #1. load the config file
 */

nutshell\util\Configuration::load('config.php');

//-- in configuration file: config.php --//
/**
 * Database(s) configuration
 * 
 * $cfg['Mysql']['Nutshell']['Hostname'] = 'localhost'; // Hostname to connect for mysql access.
 * $cfg['Mysql']['Nutshell']['Username'] = 'root'; // User to access mysql database
 * $cfg['Mysql']['Nutshell']['Password'] = 'root'; // Password for mysql's user
 * $cfg['Mysql']['Nutshell']['Database'] = 'nutshell'; // Main database for the system
 */
//-- end configuration --//

/*
 * #2. run a new operation
 */
nutshell\data\db\Database::connection('Nutshell')->newOperation();
echo '<code>nutshell\data\db\Database::connection(\'Nutshell\')->newOperation()</code>';