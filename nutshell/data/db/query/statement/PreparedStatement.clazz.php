<?php
namespace nutshell\data\db\query\statement;

use nutshell\lang\Collection;
use nutshell\data\db\Database;
use nutshell\data\db\DatabaseOperation;

/**
 * <b>PreparedStatement.clazz.php</b>: prepared statement
 * 
 * <p>A prepared statement is an sql query which has binded some cleaned and filtered
 * parameter, it is a safe query to send to the database.</p>
 * 
 * <p>Before compiling the query every parameter value is symbolized by a colon
 * followed by the name of the parameter. When compiling the query the symbol 
 * will be switched with the actual value, secured and checked, 
 * of the parameter in order to avoid failure or security breaches on the database.</p>
 * 
 * <p><u>This class prevents the SQL Injection. Should always be used when
 * quering a database for security reasons.</u></p>
 *
 * @package nutshell
 * @subpackage data\db\query\statement
 * @author sebataz <sebastien.rigoni@gmail.com>
 * @version 1.0
 * @since 2010-06-14
 */
class PreparedStatement extends SQLQuery {
    
    /**
     * Holds a collection of parameters bound to this query.
     * 
     * @var Collection Collection of parameters.
     */
    private $_statementParameters;
    
    /**
     * @see SQLQuery::__construct()
     */
    public function __construct(DatabaseOperation $_Operation, $_sql_query) {
        parent::__construct($_Operation, $_sql_query);
        $this->_statementParameters = new Collection();
    }
    
    /**
     * Binds a parameter to the query.
     * 
     * @param string $_param_name A parameter name.
     * @param string $_param_value A parameter value.
     * @param string $_param_type A parameter type. Assumes it is a string if none
     *                            is passed.
     */
    public function addParameter($_param_name, $_param_value, $_param_type = 'string') {        
        $this->_statementParameters->add($_param_name, new Collection(array($_param_value, $_param_type)));
    }
    
    /**
     * Secures and returns a parameter identified by <var>$_param_name</var>.
     * 
     * @param string $_param_name The parameter name.
     * @return mixed A parameter value.
     */
    public function getParameter($_param_name) {
        $param_value = $this->_statementParameters->get($_param_name[1])->get(0);
        $param_type = $this->_statementParameters->get($_param_name[1])->get(1);
        
        //filter by type
        switch ($param_type) {
            //escape string
            case Database::PARAM_STR:
                return $this->_Operation->escapeString($param_value);
                
            //value not filtered
            case Database::PARAM_INT:
            case Database::PARAM_NULL:
            case Database::PARAM_BOOL:
            case Database::PARAM_SQL:
            default:
                return $param_value;
        }
    }
   
    /**
     * Builds and returns the compiled query. When building the query if a
     * parameter name is found (e.g.: ":paramName") the method <kbd>self::getParameter()</kbd>
     * is called and the secured value is the inserted into the query.
     * 
     * @return string A compiled query.
     */
    public function getQuery() {        
        return preg_replace_callback('/:{1}([a-zA-Z]{1}[a-zA-Z0-9_]*)/', array($this, 'getParameter'), parent::getQuery());
    }
}
