<?php 

namespace Model;

use Connection\Connection;
use Model\Interfaces\InterfaceModel;

/**
 * Class responsible for cominication with database
 * 
 */
abstract class Model extends Connection implements InterfaceModel
{
    /**
     * Table of query
     *
     * @var string
     */
	protected $table;
    
    /**
     * Primary of table
     *
     * @var int
     */
	protected $primary_key;
    
    /**
     * Other columns of table
     *
     * @var array
     */
	protected $fields = [];
    
    /**
     * Save date insert and update in table
     *
     * @var bool
     */
	protected $timestemp = true;
    
    /**
     * Object of connection with database
     *
     * @var objecto
     */
	private $pdo;
    
    
    /**
     * Select of query
     *
     * @var string
     */
	private $_select = 'SELECT * ';
    
    /**
     * Join of query
     *
     * @var string
     */
	private $_join;
    
    /**
     * Where of query
     *
     * @var string
     */
	private $_where;
    
    /**
     * Or of query
     *
     * @var string
     */
	private $_or_where;
    
    /**
     * Like of query
     *
     * @var string
     */
	private $_like;
    
    /**
     * Limit of query
     *
     * @var string
     */
	private $_limit;
    
    /**
     * Order by of query
     *
     * @var string
     */
	private $_order_by;
    
    
    /**
     * Query built
     *
     * @var string
     */
	protected $_query;
    
    
    /**
     * Instance this class
     *
     * @var this
     */
	private static $instance;

    /**
     * Construct of class for connection with database
     * 
	 * @return void
     */	
	public function __construct()
	{
		$this->pdo = parent::connect();
	}


    /**
     * Destroy the connection with database
     * 
	 * @return void
     */	
	private function desconectar()
    {
        $this->disconnect($this->pdo);
    }
    
    
    /**
     * Function that stores the table of query
     * 
     * @param string $table
	 * @return $this
     */	
	public static function table($table)
    {
        $instance = static::getInstance();
        
        $instance->table = $table;
        return $instance;
    }
    
    
    /**
     * Function that get all registers of table
	 * @return $this
     */	
	public static function find($id)
	{   
        $instance = static::getInstance();
        
        $instance->where($instance->primary_key, $id);
        return $instance->first();
    }
    
    
    /**
     * Function that stores the content of query
     * 
     * @param string $content
	 * @return $this
     */	
	public static function select($content)
    {
        $instance = static::getInstance();
        
        $instance->_select = 'SELECT ' . $content;
        return $instance;
    }
    
    
    /**
     * Function that get all registers of table
	 * @return $this
     */	
	public static function all()
    {   
        $instance = static::getInstance();
        
        return $instance->get();
    }
    
    
    /**
     * Function that stores the where of query
     * 
     * @param string $param2
     * @param string $param1
	 * @return $this
     */	
	public static function where($param1, $param2 = false)
    {
        $instance = static::getInstance();
        
        if ($param2) {
            $instance->_where .= ' WHERE ' . $param1 . ' = ' . $param2;
        }
        
        if (is_array($param1)) {
            $instance->_where .= ' WHERE ' . $param1[0] . ' = ' . $param1[1];
        }
        
        return $instance;
    }


    /**
     * Function that stores the OR of where
     * 
     * @param string $param2
     * @param string $param1
	 * @return $this
     */	
	public static function or_where($param1, $param2 = false)
    {
        $instance = static::getInstance();
        
        if ($param2) {
            $instance->_or_where .= ' OR ' . $param1 . ' = ' . $param2;
        }
        
        if (is_array($param1)) {
            $instance->_or_where .= ' OR ' . $param1[0] . ' = ' . $param1[1];;
        }
        
        return $instance;
    }


    /**
     * Function that stores the order by of query
     * 
     * @param string $order_by
	 * @return $this
     */	
	public static function order_by($order_by)
    {
        $instance = static::getInstance();
        
        $instance->_order_by .= ' ORDER BY ' . $order_by;
        return $instance;
    }


    /**
     * Function that stores the limit of query
     * 
     * @param string $limit
	 * @return $this
     */	
	public static function limit($limit)
    {
        $instance = static::getInstance();
        
        $instance->_limit .= ' LIMIT ' . $limit;
        return $instance;
    }


    /**
     * Function that stores the join of query
     * 
     * @param string $table
     * @param string $relation
     * @param string $type
	 * @return $this
     */	
	public static function join($table, $relation, $type)
    {
        $instance = static::getInstance();
        
        if (is_array($join)) {
            $instance->_join = ' ' . $type . ' join ' . $table . ' ON ' . $relation ;
        }
        
        return $instance;
    }
    
    
    /**
     * Function that stores the like of query
     * 
     * @param string $field
     * @param string $like
	 * @return $this
     */	
	public static function like($field, $like)
    {
        $instance = static::getInstance();
        
        if ($instance->_where) {
            $instance->_like = ' AND ' . $field . ' LIKE "' . $like . '"';
        } else {
            $instance->_like = ' WHERE ' . $field . ' LIKE "' . $like . '"';
        }
        
        return $instance;
    }


    /**
     * Function that get the first result of query unknown
     * 
     * @param object PDO $return_type
	 * @return $this
     */	
	public function first($return_type = null)
    {   
        $this->getQuery();
        
        switch ($return_type) {
            case 'obj':
                $type = \PDO::FETCH_OBJ;
                break;
            
            default:
                $type = \PDO::FETCH_ASSOC;
                break;
        }
        
        $this->_query = $this->_query->fetch($type);
        
        foreach ($this->_query as $key => $value) {
            $this->$key = $value;
        }
        
	    return $this;
    }
    
    
    /**
     * Function that returns the amount of registers of query unknown
	 * @return $this
     */	
	public static function count()
    {
        $instance = static::getInstance();
        
        $instance->getQuery();
        return (int)$instance->_query->rowCount();
    }
    
    
    /**
     * Function that returns the results of query
     * 
     * @param object PDO $return_type
	 * @return $this
     */	
	public function get($return_type = 'obj')
    {
        $this->getQuery();
        
        switch ($return_type) {
            case 'obj':
                $type = \PDO::FETCH_OBJ;
                break;
            
            case 'array':
                $type = \PDO::FETCH_ASSOC;
                break;
        }
        
        $this->_query = $this->_query->fetchAll($type);
        
	    return $this->_query;
    }
    
    
    /**
     * Function that performs one query in hand
     * 
     * @param string $query
	 * @return $this
     */	
	public function query($query)
    {
        $instance = static::getInstance();
        
        $instance->_query = $query;
        return $instance;
    }
    
    
    /**
     * Function that uni as partes of query
	 * @return $this
     */	
	private function getQuery()
    {
        $this->connect();
        
        if (!$this->_query)
            $this->_query = $this->_select . ' FROM ' . $this->table . $this->_join . $this->_where . $this->_or_where . $this->_like . $this->_limit . $this->_order_by; 
        
        $this->_query = $this->pdo->prepare($this->_query);
	    return $this->_query->execute();
    }
    
    
    /**
     * Function that execute one query (update, insert, delete)
	 * @return $this
     */	
	public function execute()
    {
        $this->_query = $this->pdo->prepare($this->_query);
        
        if (!$this->_query->execute())
            return false;
            
        return (int)$this->pdo->lastInsertId();
    }
    
    
    /**
     * Function that do update in one register
     * 
     * @param string $param1
     * @param string $param2(opcional)
	 * @return $this
     */	
	public static function update($param1, $param2 = false)
    {
        $instance = static::getInstance();
        
        if ($param2) {
            $instance->query .= ' SET ' . $param1 . ' = ' . $param2;
        }
        
        if (is_array($param1)) {
            $instance->query .= ' SET ' . $param1[0] . ' = ' . $param1[1];;
        }
        
        $query = $instance->pdo->prepare('UPDATE ' . $instance->query);
	    return $query->execute();
    }
    
    
    /**
     * Function that do insert one register
	 * @return $this
     */	
	public function save()
    {
        $id = $this->primary_key;
        
        if ($this->$id) {
            $execute = $this->update_save($this->$id);
        } else {
            $execute = $this->insert_save();
        }
        
        if (substr($execute, 0, 6) == 'INSERT') {
            $return_id = true;
        }
        
        $execute = $this->pdo->prepare($execute);
        
        if (!$execute->execute()) {
            return false;
        }
        
        if (!$return_id) {
            return true;
        }
        
        return (int)$this->pdo->lastInsertId();
    }
    
    
    /**
     * Function that builds the insert
	 * @return $this
     */	
	private function insert_save()
    {
        $insert = 'INSERT INTO ' . $this->table . ' (';
        
        $value;
        
        foreach ($this->fields as $field) {
            $insert .= $field . ', ';
            $value  .= $this->$field . '", "';
        }
        
        if ($this->timestemp) {
            $insert .= 'created, updated';
            $value  .=  date('Y-m-d H:i') . '", "' . date('Y-m-d H:i') . '"';
        } else {
            $insert = substr($insert, 0, -2);
            $value  = substr($value, 0, -3);
        }
        
        return $insert . ') VALUES ("' . $value . ')';
    }
    
    
    /**
     * Função que builds the update
     * 
     * @param int $id 
	 * @return $this
     */	
	private function update_save($id)
    {
        $update = 'UPDATE ' . $this->table . ' SET ';
        
        foreach ($this->fields as $field)
            $update .= $field . ' = "' . $this->$field . '", ';
        
        if ($this->timestemp)
            $update  .=  'updated = "' . date('Y-m-d H:i') . '"';
        
        else
            $update  = substr($value, 0, -3);
        
        return $update . ' WHERE ' . $this->primary_key . ' = ' . $id;
    }
    
    
    /**
     * Function that to do delete that one register
	 * @return $this
     */	
	private function delete()
    {
        $id = $this->primary_key;
        
        if (!$this->_query)
            $delete = $this->pdo->prepare($this->_query);
        
        else
            $delete = 'DELETE ' . $this->table . ' WHERE ' . $this->$id;
        
        $delete = $this->pdo->prepare($delete);
        
        return $delete->execute();
    }
    
    
    /**
     * Get instance the class
     * @return this
     */ 
    private static function getInstance()
    {
        if (!Model::$instance) {
            Model::$instance = new static();
        }
        
        return Model::$instance;
    }
}