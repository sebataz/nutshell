<?php
namespace nutshell\lang\halt;

use \Exception;

/**
 * <b>Halt.halt.php</b>: base halt
 * 
 * <p>A <kbd>Halt</kbd> is basically an <kbd>Exception</kbd> that provides
 * an automatic method to resolve the error when a <kbd>Halt</kbd> is thrown.</p>
 * 
 * <p>This class used as an Exception halts the running script and redirects to 
 * an alternative output. The output can contain some beahveoir or actions 
 * defined by a callback function give by <var>$_fn_callback</var> as lambda
 * funtion.</p>
 * 
 * <p>A <b>lambda function</b> is a function that can be declared as a variable:
 * <br><samp>$_lambda = function ($_args) { // do something};</samp></p> 
 *
 * <p>Facendo passare una routine di comportamento all'interno di un <kbd>try</kbd>
 *  é possibile lanciare un eccezione. Di seguito ad un eccezione l'esecuzione 
 * dello script viene interrotta, riprendendo unicamente dalla parola chiave 
 * <kbd>catch</kbd>. Struttura di controllo che si occupa pure del recupero 
 * dell'eccezione. Sfruttando tale meccanismo ho esteso la classe 
 * <kbd>Exception</kbd> alla clase <kbd>Halt</kbd> per simulare l'arresto del 
 * sistema, ed il rendering di un output alternativo. L'output può sfruttare 
 * tutte le richieste eseguite dall'utente in quando questo metodo riscrive 
 * unicamente l'output.</p>
 *
 * @package nutshell
 * @subpackage lang\halt
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 1.1
 * @since 2010-04-04
 */
class Halt extends Exception {
    
   /**
    * The callback function that is called on restore.
    * 
    * @var lambda The callback function.
    */ 
    protected $_fnCallback = null;

    /**
     * Sets the halt message.
     * 
     * @param string $_message The halt message.
     * @param labmda $_fn_callback The callback restore function.
     */
    public function __construct($_message='end', $_fn_callback=null) {
        parent::__construct($_message);
        $this->_fnCallback = $_fn_callback;
    }

    /**
     * Restores the output for the page after a halt. Calls the callback
     * function if any, otherwise fires the event <kbd>onRestore()</kbd>.
     */
    final public function restore() {
        $_fn = $this->_fnCallback;
        isset($_fn) ? $_fn(): $this->onRestore();
    }

    /**
     * Renders an alternative output.
     */
    protected function onRestore() {
        $this->printStackTrace();
    }
    
    /**
     * Formats the stack trace into a string and prints it to screen
     */
    public function printStackTrace() { 
        $stack_trace = $this->getTrace();
        $string_trace = "\n<br /><strong>" . get_class($this) . '</strong>: ' 
                      . $this->getMessage() . "<br />"
                      . "\n#0 in " . $this->getFile() . ' on line ' . $this->getLine()
                      . ': ' . $this->getMessage() . '<br \>';
        
        for ($i = 1; $i <= count($stack_trace); $i++) {
            
            // get file and line where runtime halts
            if (key_exists('file', $stack_trace[$i-1])) {
                $string_trace .= "\n#" . $i . ' in ' . $stack_trace[$i-1]['file'];
                $string_trace .= ' on line ' . $stack_trace[$i-1]['line'] . ': ';
            } else
                $string_trace .= "\n#" . $i . ' [internal function]: ';
            
            // check if it is a class that halts 
            if (array_key_exists('class', $stack_trace[$i-1])) {
                $string_trace .= $stack_trace[$i-1]['class'];
                $string_trace .= $stack_trace[$i-1]['type'] ;
            }
            
            // function or method that halts
            $string_trace .= $stack_trace[$i-1]['function'] . '(';
            
            // parses function or method's parameters if any
            if (array_key_exists('args', $stack_trace[$i-1])) {
                for ($c = 0; $c < count($stack_trace[$i-1]['args']); $c++) {
                                        
                    // is argument null?
                    if (is_null($stack_trace[$i-1]['args'][$c]))
                        $stack_trace[$i-1]['args'][$c] = 'NULL';
                    
                    // is argument a boolean false?
                    else if ($stack_trace[$i-1]['args'][$c] === false)
                        $stack_trace[$i-1]['args'][$c] = 'FALSE';
                    
                    // is argument a boolean true?
                    else if ($stack_trace[$i-1]['args'][$c] === true)
                        $stack_trace[$i-1]['args'][$c] = 'TRUE';
                    
                    // is argument an array?
                    else if (is_array($stack_trace[$i-1]['args'][$c]))
                        $stack_trace[$i-1]['args'][$c] = 'Array';
                    
                    // get class name if parameter is an object
                    else if (is_object($stack_trace[$i-1]['args'][$c]))
                        $stack_trace[$i-1]['args'][$c] = 
                        'Object(' . get_class($stack_trace[$i-1]['args'][$c]) . ')';
                    
                    // trims string if too long
                    else if (strlen($stack_trace[$i-1]['args'][$c]) > 20)
                        $stack_trace[$i-1]['args'][$c] = '...' . substr ($stack_trace[$i-1]['args'][$c], -20);
                }
                
                // glue parameters together
                $string_trace .= implode(', ', $stack_trace[$i-1]['args']);
            }
            
            $string_trace .= ')<br />';
        }
        
        // print formatted stack trace
        echo $string_trace . "\n#" . $i++ . ' what the fuck dude!<br />';
    }
}
