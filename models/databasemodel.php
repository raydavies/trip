<?php
class Database {

	public $mysqli;
	private $host;
	private $username;
	private $password;
	private $getter;
	private $getpw;
	public $global_db;
	public $config;

	public function __construct()
	{
		require_once('config.php');
		$this->config = Config::get_configs();
		$this->host = $this->config['host'];
		$this->username = $this->config['username'];
		$this->password = $this->config['password'];
		$this->global_db = $this->config['global_db'];
		$this->getter = $this->config['getter'];
		$this->getpw = $this->config['getpw'];
		$this->connect();
	}

	public function connect()
	{
		$this->mysqli = new mysqli($this->host,$this->getter,$this->getpw);
		
		if (!$this->mysqli)
		{
			echo 'Could not connect ('.$this->mysqli->connect_errno.'): '.$this->mysqli->connect_error;
		}
	}

	public function select_db($database)
	{
		$this->mysqli->select_db($database);
			
		if ($this->mysqli->errno)
		{
			echo 'SQL Select Error ('.$this->mysqli->errno.'): '.$this->mysqli->error;
		}
	}

	public function query($query)
	{
		$result = $this->mysqli->query($query);
		if ($this->mysqli->errno)
		{
			echo 'SQL Query Error ('.$this->mysqli->errno.'): '.$this->mysqli->error;
			return false;
		}
		return $result;
	}

	public function close()
	{
		$this->mysqli->close();
	}
}
?>
