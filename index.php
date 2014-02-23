<?php
if (isset($_SERVER['REQUEST_URI']))
{
	define('BASEPATH', $_SERVER['DOCUMENT_ROOT']);
	define('APPPATH', BASEPATH.'/application');
	define('VIEWPATH', APPPATH.'/views');
    
    require_once '../vendor/autoload.php';

    $finder = new Symfony\Component\Finder\Finder();
    $finder->in(APPPATH.'/controllers')->in('./vendor/');

	$params = array();
	$uri = $_SERVER['REQUEST_URI'];
	$chunks = explode('?', $uri);

	if (count($chunks) > 1)
	{
		$uri = $chunks[0];
		$query = array();
		$vars = explode('&', $chunks[1]);
		if (count($vars) > 1)
		{
			foreach ($vars as $var)
			{
				$pair = explode('=', $var);
				$query[$pair[0]] = $pair[1];
			}
		}
		else
		{
			$pair = explode('=', $chunks[1]);
			$query[$pair[0]] = $pair[1];
		}
	}
	$segments = explode('/', $uri);

	session_start();
	$_SESSION['http_referer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

	/*if (!empty($segments[2]))
	{
		if (is_file(APPPATH.'/'.$segments[2].'.php'))
		{
			$class = $segments[2];
			include_once(APPPATH.'/'.$class.'.php');
		}
		else
		{
			include_once(APPPATH.'/page.php');
		}
	}
	else
	{*/
		//include_once(APPPATH.'/page.php');
	//}
}
?>
