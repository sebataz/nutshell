<?php 
/**
 * Nutshell Example: database use
 * 
 * First of all you need to create a database called 'nutshell', please check
 * that database access parameters are valid below or in config file. Once you
 * have a connection instatiated you can query it.
 */


// Nutshell autoloader
include '../nutshell/Nutshell.autoloader.php'; 

/*
 *  #1. instantiate a db connection
 */
$Connection = new nutshell\data\db\driver\pdo\PDOConnection('localhost', 'nutshell', 'root', '');


/*
 *  #2. create a new table.
 */
$TableColumns = new nutshell\lang\Collection();
$TableColumns->add('Id', 'INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY');
$TableColumns->add('Text', 'VARCHAR(200)');
$Connection->newOperation()->createTable('Example', $TableColumns);

/*
 * #3: insert a row
 */
$ColumnValues = new nutshell\lang\Collection();
$ColumnValues->add('Text', 'entry #0');

$InsertQuery = new nutshell\data\db\query\InsertQuery($Connection->newOperation(), 'Example', $ColumnValues);
foreach ($ColumnValues as $column => $value) {
    $InsertQuery->addParameter($column, $value);
}
$InsertQuery->send();

/*
 * #4: select rows from table
 */
$SelectQuery = new nutshell\data\db\query\SelectQuery($Connection->newOperation(), 'Example');
$Collection = $SelectQuery->send();

foreach ($Collection as $Row) {
    echo 'Text: ', $Row->Text, ' <br />';
}

/*
 * #5: update a row
 */
$ColumnValues = new nutshell\lang\Collection();
$ColumnValues->add('Text', 'entry #1');

$UpdateQuery = new nutshell\data\db\query\UpdateQuery($Connection->newOperation(), 'Example', $ColumnValues);
$UpdateQuery->where('ID=1');
foreach ($ColumnValues as $column => $value) {
    $UpdateQuery->addParameter($column, $value);
}
$UpdateQuery->send();

/*
 * #6: select rows from table
 */
$SelectQuery = new nutshell\data\db\query\SelectQuery($Connection->newOperation(), 'Example');
$Collection = $SelectQuery->send();

foreach ($Collection as $Row) {
    echo 'Text: ', $Row->Text, ' <br />';
}

/*
 * #7: delete a row
 */
$DeleteQuery = new nutshell\data\db\query\DeleteQuery($Connection->newOperation(), 'Example');
$DeleteQuery->where('ID=1');
$DeleteQuery->send();

/*
 * #8: empty and drop a table
 */
$Connection->newOperation()->emptyTable('Example');
$Connection->newOperation()->dropTable('Example');