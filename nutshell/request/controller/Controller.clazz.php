<?php
namespace nutshell\request\controller;

use nutshell\lang\Object;
use nutshell\lang\ArrayMap;
use nutshell\lang\halt\Halt;
use nutshell\request\Request;

/**
 * <b>Controller.clazz.php</b>: controller base class
 * 
 * <p>The main task of the controller is to take the user request and prepare a
 * response (output).</p>
 * 
 * <p>The controller defines the public variables that will be returned when a 
 * <kbd>get</kbd> is peformed or referenced in a page that will be published.</p>
 * 
 * The controller manages a pseudo life-cycle: onRequest > onGet/onPost
 * <ul>
 *      <li><b>onRequest()</b>: is invoked right after a controller has been instatiated,
 *                     when a request has been passed to the application. This 
 *                     is the moment when the request has to be parsed, or some
 *                     preparation job can be done.</li>
 *      <li><b>onGet()</b>: is invoked when the controller performs a get request or
 *                      right before a page is loaded to publish.</li>
 *      <li><b>onPost()</b>: is invoked when the controller performs a post request.</li>
 * </ul>
 * 
 * <p>The class is also responsible to bind request variables to a callback method.
 * The binding of an action should be called inside the <kbd>onGet()</kbd> and 
 * <kbd>onPost()</kbd> methods.</p>
 * 
 * <p><u>NOTE</u>: There is not a specified order in which <kbd>get</kbd> and
 * <kbd>post</kbd> are done.</p>
 * 
 * <p><u>NOTE</u>: If a variable is defined with the same name in both <var>$_GET</var>
 * and <var>$_POST</var> the <kbd>onGet()</kbd> and <kbd>onPost<kbd> method will get
 * the correct value of the variable (i.e.: onGet() <- $_GET; onPost() <- $_POST).</p>
 * 
 * @abstract
 * @package nutshell
 * @subpackage request\controller
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 1.1
 * @since 2010-04-04
 */
abstract class Controller extends Object {
    
    /**
     * The request method that is beeing managed by the controller.
     *
     * @var string The request method.
     */
    private $_method = 'get';
    
    /**
     * Invoked right after the controller has been instatiated.
     */
    abstract public function onRequest();
    
    /**
     *  Invoked when the controller performs a get request.
     */
    abstract public function onGet();
    
    /**
     * Invoked when the controller performs a post request.
     */
    abstract public function onPost();
    
    /**
     * Binds request variables to a callback action.
     * 
     * @param string $_callback_action A method name.
     * @param string $_request_variables Request variable names passed as single argument.
     * @return mixed The callback return value.
     */
    public function bindAction($_callback_action, $_request_variables) {
        $callback_arguments = array();
        $_request_variables = array_slice(func_get_args(), 1);
        
        foreach ($_request_variables as $variable_name) {
            // use get or post variables
            $Request = call_user_func_array(array('nutshell\request\Request', $this->_method), array());
            
            // do nothing if variables are not defined.
            if (!$Request->null($variable_name))
                return false;
            
            else 
                $callback_arguments[] = $Request->$variable_name;
        }
        
        // callback
        if ($this->methodExists($_callback_action))
            return $this->callback($_callback_action, $callback_arguments);
    }
    
    /**
     * Performs a get request and returns an array map of public variables or an
     * empty one if the request fails.
     * 
     * @return ArrayMap An array map of the controller's public variables.
     */
    public function get() {
        
        // change request method
        $this->_method = 'get';
        
        try {
        
            // onGet behaviour
            $this->onGet();
            return $this->getObjectProperties();
            
        } catch (Halt $Halt) {
            // empty array map on failure
            return new ArrayMap();
        }
            
    }
    
    /**
     * Performs a post request.
     * 
     * @return bool <b>TRUE</b> if post successful, otherwise <b>FALSE</b>.
     */
    public function post() {
        
        // change request method
        $this->_method = 'post';
        try {
            
            // onPost behaviour
            $this->onPost();
            return true;
            
        } catch (Halt $Halt) { 
            // false on failure
            return false;
        }
    }
}
