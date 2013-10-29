<?php
namespace nutshell\request;

use nutshell\lang\Clazz;
use nutshell\request\http\Session;
use nutshell\request\http\Variable;

/**
 * <b>Request.clazz.php</b>: request variable handler
 * 
 * <p>Wrapper for the request variables <var>$_GET</var>, <var>$_POST</var> and
 * <var>$_SESSION</var>. The variables are wrapped into an <kbd>ArrayMap</kbd>.</p>
 *
 * @package nutshell
 * @subpackage request
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-07-10
 */
abstract class Request extends Clazz {
    
    /**
     * Redirects to location identified by <var>$_url</var>.
     * 
     * @param string $_url Redirect url.
     */
    public static function redirect($_url) {
        header('Location:' . $_url);
    }
    
    /**
     * Returns a singleton instance of <var>$_GET</var> into an <kbd>ArrayMap</kbd>.
     * 
     * @staticvar Variable $Get Singleton instance of <var>$_GET</var>.
     * @return Variable Singleton instance of <var>$_GET</var>.
     */
    public static function get() {
        static $Get;
        
        if (null === $Get) 
            $Get = new Variable($_GET);
        
        return $Get;
    }
    
    /**
     * Returns a singleton instance of <var>$_POST</var> into an <kbd>ArrayMap</kbd>.
     * 
     * @staticvar Variable $Post Singleton instance of <var>$_POST</var>.
     * @return Variable Singleton instance of <var>$_POST</var>.
     */
    public static function post() {
        static $Post;
        
        if (null === $Post) 
            $Post = new Variable($_POST);
        
        return $Post;
    }
    
    /**
     * Returns a singleton instance of <var>$_SESSION</var> into an <kbd>ArrayMap</kbd>.
     * 
     * @staticvar Session $Session Singleton instance of <var>$_SESSION</var>.
     * @return Session Singleton instance of <var>$_SESSION</var>.
     */
    public static function session() {
        static $Session;
        
        if (null === $Session) 
            $Session = new Session();
        
        return $Session;
    }
}
