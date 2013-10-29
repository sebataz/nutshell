<?php
namespace nutshell\data\db\query\statement;

/**
 * <b>PagedStatement.clazz.php</b>: paged statement
 * 
 * <p>This class adds the possibility to limit the result set of a query.</p>
 *
 * @package nutshell
 * @subpackage data\db\query\statement
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-17
 */
class PagedStatement extends SortStatement {
    
    /**
     * Holds the limit clause.
     *
     * @var string Limit clause.
     */
    private $_limitTo;
    
    /**
     * Builds and sets the limit clause for the query.
     * 
     * @param int $_count Number of rows per set.
     * @param int $_offset Starting rows.
     * @return PagedStatement This statement.
     */
    public function limitTo($_count, $_offset=0) {
        $this->_limitTo = ' LIMIT ' . $_offset . ', ' . $_count;
        return $this;
    }
    
    /**
     * Builds and returns a compiled query.
     * 
     * @return string The compiled query.
     */
    public function getQuery() {
        return parent::getQuery() . $this->_limitTo;
    }
}
