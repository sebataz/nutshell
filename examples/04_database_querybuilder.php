<?php 
/**
 * Nutshell Example: querybuilder use
 * 
 * 
 */


// Nutshell autoloader
include '../nutshell/Nutshell.autoloader.php'; 

/*
 * #1. instatiate a querybuilder with a connection
 */
$Connection = new nutshell\data\db\driver\pdo\PDOConnection('localhost', 'nutshell', 'root', '');
$QueryBuilder = new nutshell\data\db\QueryBuilder($Connection);

/*
 *  #2. create a new table.
 */
$TableColumns = new nutshell\lang\ArrayMap();
$TableColumns->add('ID', 'INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY');
$TableColumns->add('Text', 'VARCHAR(200)');

$Connection->newOperation()->createTable('Example', $TableColumns);

/*
 * #3: insert a row
 */
$ColumnValues = new nutshell\lang\ArrayMap();
$ColumnValues->add('Text', 'entry #0');

$QueryBuilder->insert('Example', $ColumnValues)->send();

/*
 * #4: select rows from table
 */
$Collection = $QueryBuilder->select('Example')->send();

foreach ($Collection as $Row) {
    echo 'Text: ', $Row->Text, ' <br />';
}

/*
 * #5: update a row
 */
$ColumnValues = new nutshell\lang\ArrayMap();
$ColumnValues->add('Text', 'entry #1');

$QueryBuilder->update('Example', $ColumnValues)->send();

/*
 * #6: select rows from table
 */
$Collection = $QueryBuilder->select('Example')->send();

foreach ($Collection as $Row) {
    echo 'Text: ', $Row->Text, ' <br />';
}

/*
 * #7: delete a row
 */
$QueryBuilder->delete('Example')->where('ID=1')->send();

/*
 * #8: empty and drop a table
 */
$Connection->newOperation()->emptyTable('Example');
$Connection->newOperation()->dropTable('Example');
