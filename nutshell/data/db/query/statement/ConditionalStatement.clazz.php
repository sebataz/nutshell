<?php
namespace nutshell\data\db\query\statement;

/**
 * <b>ConditionalStatement.clazz.php</b>: conditional statement
 * 
 * <p>This is basically the <kbd>WHERE</kbd> clause in a query.</p>
 * 
 * <p> It is useful to apply some conditions and criteria to a query before it is
 * sent to the database. This class offers some straightforward methods 
 * to create a custom data set for any query.</p>
 * 
 * <p>The <kbd>WHERE</kbd> clause is set to <kbd>WHERE 1 ...</kbd>, all the
 * criteria and condition are appended to the clause with the <kbd>AND</kbd>
 * operator (e.g.: <kbd>SELECT * FROM Example WHERE 1 AND ID=1 AND ID!=2 ...</kbd>).</p>
 *
 * @package nutshell
 * @subpackage data\db\query\statement
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 0.0
 * @since 2013-05-17
 */
class ConditionalStatement extends PreparedStatement {
    
    /**
     * Holds all the query conditions.
     * 
     * @var array Array of conditions
     */
    private $_whereClause = array();
    
    /**
     * Sets a raw <kbd>WHERE</kbd> clause to the query.
     * 
     * @param string $_where A raw <kbd>WHERE</kbd> clause.
     * @return ConditionalStatement This statement.
     */
    public function where($_where) {
        $this->_whereClause[] = ' AND ' . $_where;
        return $this;
    }
    
    /**
     * Sets a <kbd>WHERE</kbd> clause with the <kbd>=</kbd> operator.
     * 
     * @param string $_field The column name.
     * @param mixed $_value The value to check.
     * @return ConditionalStatement This statement.
     */
    public function criteria($_field, $_value) {
        $this->_whereClause[] = ' AND ' . $_field . '=' . $_value;
        return $this;
    }
    
    /**
     * Sets a <kbd>WHERE</kbd> clause with the <kbd>LIKE</kbd> operator.
     * 
     * @param string $_field The column name.
     * @param mixed $_like The value to check.
     * @return ConditionalStatement This statement.
     */
    public function like($_field, $_like) {
        $this->_whereClause[] = ' AND ' . $_field . ' LIKE "%' . $_like . '%" ';
        return $this;
    }
    
    /**
     * Builds and returns the compiled query ready to be executed.
     * 
     * @return string The compiled query.
     */
    public function getQuery() {
        return parent::getQuery() . ' WHERE 1' . implode(' ', $this->_whereClause);
    }
}
