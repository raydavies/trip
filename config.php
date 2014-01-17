<?php
class Config {
	public static $config;
	public static $timezone;

	public static function set_timezone($zone='America/Chicago')
	{
		date_default_timezone_set($zone);
		$this->timezone = $zone;
	}

	public static function get_timezone()
	{
		return $this->timezone;
	}

	public static function get_configs()
	{
		self::$config = array();
		self::$config['environment'] = 'production';
		//self::$config['environment'] = 'development';

		if (self::$config['environment'] == 'production'){
			self::$config['host'] = 'localhost';
			self::$config['username'] = 'mumbles_jordan';
			self::$config['password'] = 'icedm1lk';
			self::$config['global_db'] = 'mumbles_trip';
			self::$config['getter'] = 'mumbles_getter';
			self::$config['getpw'] = 'Hyp3rDr1v3!';
		}

		else {
			self::$config['host'] = 'localhost';
			self::$config['username'] = 'root';
			self::$config['password'] = 'icedm1lk';
			self::$config['global_db'] = 'mumbles_trip';
			self::$config['getter'] = 'root';
			self::$config['getpw'] = 'icedm1lk';
		}
		return self::$config;
	}
}
?>
