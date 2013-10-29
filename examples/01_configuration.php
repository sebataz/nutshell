<?php
/**
 * Nutshell Example: configuration file
 * 
 * Nutshell manages the configuration of your application through a single file
 * in order to have you configuration throughout the whole application you will
 * have to initialize the configuration at the beginning of you script
 */

// Nutshell autoloader
include '../nutshell/Nutshell.autoloader.php'; 

// set the configuration file source
nutshell\util\Configuration::load('config.php'); // setting a configuration file

// get configuration value at
echo '<code>nutshell\util\Configuration::at()->Mysql->Nutshell->Hostname</code> : ',
     nutshell\util\Configuration::at()->Mysql->Nutshell->Hostname; 
echo '<br /><code>nutshell\util\Configuration::at()->Mysql->Nutshell->Database</code> : ',
     nutshell\util\Configuration::at()->Mysql->Nutshell->Database; 
echo '<br /><code>nutshell\util\Configuration::at()->Mysql->Nutshell->Username</code> : ',
     nutshell\util\Configuration::at()->Mysql->Nutshell->Username; 
echo '<br /><code>nutshell\util\Configuration::at()->Mysql->Nutshell->Password</code> : ',
     nutshell\util\Configuration::at()->Mysql->Nutshell->Password; 