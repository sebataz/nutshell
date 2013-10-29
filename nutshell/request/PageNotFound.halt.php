<?php
namespace nutshell\request;

use nutshell\lang\halt\Halt;

/**
 * <b>PageNotFound.halt.php<b>: page not found halt
 * 
 * <p>Thrown when page is not found for the current loaded site. This class
 * accepts an optional page to load instead of the missing page.</p>
 *
 * @package nutshell
 * @subpackage request
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 1.0
 * @since 2010-04-04
 */
class PageNotFound extends Halt {
    
    /**
     * This is an alternative page that will be loaded if a page is not found.
     * 
     * @var string Redirect page.
     */
    private $_redirect_page;

    /**
     * The construct creates the missing page message for this halt.
     * 
     * @param type $_page_not_found The page not found.
     * @param type $_redirect_page The alternative page to load.
     */
    public function PageNotFound($_page_not_found, $_redirect_page = null) {
        parent::__construct('page not found ' . str_replace(Nutshell::cfg()->Extensions->Page, '', $_page_not_found));
        $this->_redirect_page = $_redirect_page;
    }
    
    /**
     * If <var>$_redirect_page</p> is declared it will be loaded instead of the
     * not found page.
     */
    protected function onRestore() {
        if ($this->_redirect_page && file_exists($this->_redirect_page))
            include $this->_redirect_page;
        else
            parent::onRestore();
    }
}
