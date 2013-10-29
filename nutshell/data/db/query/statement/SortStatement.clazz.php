<?php
namespace nutshell\data\db\query\statement;

/**
 * <b>SortedStatement.clazz.php</b>: sorted statement
 * 
 * <p>This class adds the possibility to order the result set of a query.</p>
 *
 * @package nutshell
 * @subpackage data\db\query\statement
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-17
 */
class SortStatement extends ConditionalStatement {
    
    /**
     * Holds the order by clause.
     *
     * @var string Order clause.
     */
    private $_orderBy;
    
    /**
     * Builds and set the order by clause for this query.
     * 
     * @param string $_column Column/s to be ordered.
     * @param string $_order Direction of the ordered data: <b>ASC</b>, <b>DESC</b>.
     * @return SortStatement This statement.
     */
    public function orderBy($_column, $_order='ASC') {
        $this->_orderBy = ' ORDER BY ' . $_column . ' ' . $_order;
        return $this;
    }
    
    /**
     * Builds and returns the query.
     * 
     * @return string The compiled query.
     */
    public function getQuery() {
        return parent::getQuery() . $this->_orderBy;
    }
}
