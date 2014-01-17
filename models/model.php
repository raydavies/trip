<?php

class Model {
	public $db;
	public $global_db;
	public $site_id;
	public $site_db;
	public $site_url;
	public $site_name;
	public $theme;
	protected $session;
	private static $instance;

	public function __construct()
	{
		$this->get_db();
		$this->get_site();
		self::$instance = &$this;
	}

	public static function &get_instance()
	{
		return self::$instance;
	}

	public function get_db()
	{
		require_once('models/databasemodel.php');
		$db = new Database;
		$this->db = &$db->mysqli;
		$this->global_db = $db->global_db;
	}

	public function session_load($key, $value)
	{
		if (empty($this->session))
		{
			session_start();
			$this->session = $_SESSION;
		}
		$this->session[$key] = $value;
	}

	public function get_site()
	{
		$segments = explode('/', $_SERVER['REQUEST_URI']);
		$result=$this->db->query("SELECT site_id, site_db, url, title FROM ".$this->global_db.".sites WHERE url = '".$segments[1]."' AND url_crc = ".crc32($segments[1])." LIMIT 1");
		if ($result && $result->num_rows == 1)
		{
			$s = $result->fetch_assoc();
			$this->site_id = $s['site_id'];
			$this->site_db = $s['site_db'];
			$this->site_url = $s['url'];
			$this->site_name = $s['title'];
			
			$t=$this->db->query("SELECT t.theme FROM ".$this->global_db.".themes as t LEFT JOIN ".$this->global_db.".sites_themes AS st ON st.theme_id = t.theme_id WHERE st.site_id = ".$this->site_id." LIMIT 1");
			if ($t && $t->num_rows)
			{
				$theme = $t->fetch_assoc();
				$this->theme = $theme['theme'];
			}
		}
		else
		{
			header("Location: /");
			die;
		}
	}
}
?>
