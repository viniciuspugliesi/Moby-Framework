<?php 

namespace Connection;

use \PDO;
use Exception\RenderException;
use Connection\Interfaces\InterfaceConnection;

/**
 * Class responsible for connetion with database
 * This class is extends for class Model and class Console/CreateModels
 */
class Connection implements InterfaceConnection
{
	/**
	 * dns of this connection
	 * 
	 * @var string
	 */ 
	private $dns;
	
	
	/**
	 * host of this connection
	 * 
	 * @var string
	 */ 
	private $host;
	
	
	/**
	 * database of this connection
	 * 
	 * @var string
	 */ 
	private $database;
	
	
	/**
	 * charset of this connection
	 
	 * @var string
	 */ 
	private $charset;
	
	
	/**
	 * user of this connection
	 
	 * @var string
	 */ 
	private $user;
	
	
	/**
	 * pass of this connection
	 
	 * @var string
	 */ 
	private $pass;
	
	
    /**
     * Function responsible for accomplish the connection with database
     * 
	 * @return object PDO
     */	
	public function connect()
	{
		$this->setAttributes();
				
		switch ($this->dns) {
			case 'mysql':
				
				try {
				    $con = new PDO("$this->dns:host=$this->host;dbname=$this->database; charset=$this->charset", $this->user, $this->pass);
				    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				} catch(PDOException $e) {
				    throw $e;
				} catch (RenderException $e) {
					$e->render($e->showErrors(), $e);
				}
				
				break;
				
			case 'oracle':
				
				$tns = " (DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$this->host.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$this->database.")))";
			
				try {
				    $con =  new PDO("oci:dbname=".$tns, $this->user, $this->pass);
				    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				} catch(PDOException $e) {
				    throw $e;
				} catch (RenderException $e) {
					$e->render($e->showErrors(), $e);
				}
				
				break;
				
			case 'sqlserver':
				
				try {
				    $con = new PDO( "sqlsrv:server=$this->host; Database=$this->database", $this->user, $this->pass);  
				    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				} catch(PDOException $e) {
				    throw $e;
				} catch (RenderException $e) {
					$e->render($e->showErrors(), $e);
				}
				
				break;
		}
		
		return isset($con) ? $con : '';
	}
	
	
    /**
     * Function reponsible for unset the connection with database
     * 
	 * @param  object  PDO
	 * @return bool
     */	
	public function disconnect($con)
	{
		$con = null;
		return true;
	}
	
	
    /**
     * Function reponsible for set the attributes of this class
     *
	 * @return void
     */	
	private function setAttributes()
	{
		$config_connection = require(__DIR__ . '/../../../App/Config/database.php');
		
		try {
			if (!isset($config_connection['default']) || !$config_connection['default']) {
				throw new RenderException('Default connection not found!', 1070);
			}
			
			$config_connection = $config_connection[$config_connection['default']];
				
			if (!isset($config_connection['host']) || !$config_connection['host']) {
				throw new RenderException('Database error! HOST not be null', 1080);
			}
			
			if (!isset($config_connection['user']) || !$config_connection['user']) {
				throw new RenderException('Database error! USER not be null', 1080);
			}
			
			if (!isset($config_connection['pass']) || !$config_connection['pass']) {
				throw new RenderException('Database error! PASS not be null', 1080);
			}
			
			if (!isset($config_connection['charset']) || !$config_connection['charset']) {
				throw new RenderException('Database error! CHARSET not be null', 1080);
			}
			
			if (!isset($config_connection['database']) || !$config_connection['database']) {
				throw new RenderException('Database error! DATABASE not be null', 1080);
			}
			
			if (!isset($config_connection['dns']) || !$config_connection['dns']) {
				throw new RenderException('Database error! DNS not be null', 1080);
			}
		} catch(RenderException $e) {
		    $renderExcepiton->render($e->showErrors(), $e);
		}
		
		$this->host		= $config_connection['host'];
		$this->user		= $config_connection['user'];
		$this->pass		= $config_connection['pass'];
		$this->charset	= $config_connection['charset'];
		$this->database = $config_connection['database'];
		$this->dns		= $config_connection['dns'];
	}
}