<?php
namespace nutshell\request;

use nutshell\lang\Clazz;
use nutshell\request\controller\Controller;

/**
 * <b>Responder.clazz.php</b>: http request handler
 * 
 * <p>Handles the request through a <kbd>Controller</kbd> class and defines
 * the behaviour to respond at a request.</p>
 * 
 * <p>The access method to this class is <kbd>Responder::request()</kbd> which
 * creates a new instance of a <kbd>Responder</kbd> holding an instance of
 * a <kbd>Controller</kbd> that solves the request.</p>
 * 
 * @package nutshell
 * @subpackage request
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-07-10
 */
class Responder extends Clazz {
    
    /**
     * Holds a list of responder organized by controller.
     * 
     * @var array Array of responders.
     */
    private static $_Responders = array();
    
    /**
     * Holds a controller instance.
     * 
     * @var Controller A Controller instance.
     */
    private $_Controller;
    
    /**
     * Creates a new responder object and its relative controller.
     * 
     * @param string $_controller A controller name.
     * @return Responder The responder instance with the controller.
     */
    public static function request($_controller) {
        
        // check if new contrller is needed
        if (!isset(self::$_Responders[$_controller])) {
            
            // create new contrller
            $Controller = new $_controller();
            
            // notify to controller the request
            $Controller->onRequest();
            
            // store responder instance
            self::$_Responders[$_controller] = new self($Controller);
        }
        
        return self::$_Responders[$_controller];
    }
    
    /**
     * Sets the responder's controller.
     * 
     * @param Controller $_Controller The controller instance.
     */
    public function __construct(Controller $_Controller) {
        $this->_Controller = $_Controller;
    }
    
    /**
     * Notifies the controller to perfom a <kbd>get</kbd>.
     * 
     * @return ArrayMap An array map of public variables.
     */
    public function get() {
        return $this->_Controller->get();
    }
    
    /**
     * Notifies the controller to perfom a <kbd>post</kbd>
     * 
     * @return bool <b>TRUE</b> if post is successful, otherwise <b>FALSE</b>.
     */
    public function post() {
        return $this->_Controller->post();
    }
    
    /**
     * Notifies the controller to perform a <kbd>get</kbd> and load a page with
     * the accessible public variables. The method will catch and manage any 
     * thrown halt.
     * 
     * @param string $_page A page to load.
     * @throws PageNotFound Thrown if the page is not found.
     */
    public function publish($_page) {
        try {
            // check if page exist
            if (!file_exists($_page))
                throw new PageNotFound($_page, '404.php');
            
            // sets the accessible public variables.
            foreach ($this->_Controller->get() as $variable => $value)
                $$variable = $value;
            
            // include page
            include $_page;

        } catch (Halt $H) { $H->restore(); }
    }
}
