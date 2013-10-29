<?php
/**
 * Nutshell Example: use of controllers
 */

// Nutshell autoloader
include '../nutshell/Nutshell.autoloader.php'; 

/*
 * #0. declare a controller
 */ 
class Example extends nutshell\request\controller\Controller {
    public $GetVariable;
    public $PostVariable;
    
    public function onGet() {
        $this->bindAction('getSomeData', 'get');
    }

    public function onPost() {
        if (!nutshell\request\Request::post()->null('post')) 
            throw new nutshell\lang\halt\Halt();
        
        $this->bindAction('postSomeData', 'post');
    }

    public function onRequest() {
    }    
    
    protected function getSomeData($_get) {
        $this->GetVariable = $_get;
    }
    
    protected function postSomeData($_post) {
        $this->PostVariable = $_post;
    }
}

/*
 * #1a. invoke the controller: to get some data
 */
$Collection = nutshell\request\Responder::request('Example')->get();

/*
 * #1b. invoke the controller: to post some data
 */
$Boolean = nutshell\request\Responder::request('Example')->post();

/*
 * #1c. invoke the controller: to publish a page with some data
 */
nutshell\request\Responder::request('Example')->publish('publish_page.php');
