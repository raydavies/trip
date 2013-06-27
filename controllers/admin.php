<?php
include_once(BASEPATH.'/models/pagemodel.php');
ob_start();
if (!empty($segments[2]))
{
	$path = $_SERVER['DOCUMENT_ROOT'].'/trip';
	if ($segments[2] == 'admin')
	{
		$params['flag_admin'] = 1;
	}

	for ($i=1; $i<count($segments) ; $i++)
	{
		if ($i == 1)
		{
			continue;
		}
		if (!empty($segments[$i]))
		{
			$path .= "/".$segments[$i];
		}
	}
	//echo $path;
	if (file_exists($path.".php"))
	{
		$params['pathname'] = $path.".php";
	}
	else
	{
		$params['pathname'] = $path."/front.php";
	}
	if (isset($query))
	{
		$params['query_string'] = $query;
	}
	//var_dump($params);
}
else
{
	$params['pathname'] = $_SERVER['DOCUMENT_ROOT']."/trip/front.php";
}

if (empty($segments[3]))
{
	$segments[3] = 'front';
}

$page = new Page($params);
if (!isset($_SESSION['username']))
{
	include_once(APPPATH.'/admin/login.php');
}
elseif (is_file(APPPATH.'/admin/'.$segments[3].'.php'))
{
	include_once(APPPATH.'/admin/'.$segments[3].'.php');
}
else
{
	include_once(VIEWPATH.'/404.php');
}
?>
