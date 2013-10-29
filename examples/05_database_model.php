<?php
/**
 * Nutshell Example: use of database models
 */

// Nutshell autoloader
include '../nutshell/Nutshell.autoloader.php'; 

/*
 * #0. declare a model
 */
class Example extends nutshell\model\db\DbModel {
    protected $Text;
    const Text = 'VARCHAR(200)';
    
    public function __construct() {
        $this->Text = 'entry #0';
    }
    
    public function echoText() {
        echo 'Text: ', $this->getText();
    }
}

/*
 * #1. register the model to a data source
 */
$DataSource = new nutshell\data\db\driver\pdo\PDOConnection('localhost', 'nutshell', 'root', '');
Example::register($DataSource);

/*
 * #2. create and save a new 'Example'
 */
$Example = new Example();
$Example->save();

/*
 * #3. find a model collection
 */
$Collection = Example::find()->toCollection();
foreach ($Collection as $Example) {
    $Example->echoText();
}

echo '<br />';

/*
 * #3. make change and save
 */
$Example->setText('entry #1');
$Example->save();

/*
 * #4. find a model collection
 */
$Collection = Example::find()->toCollection();
foreach ($Collection as $Example) {
    $Example->echoText();
}

/*
 * #5. drop table
 */
$DataSource->newOperation()->dropTable('Example');
