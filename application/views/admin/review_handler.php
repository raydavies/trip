<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title><?php echo $page->title; ?></title>
<link rel="stylesheet" type="text/css" href="/trip/assets/css/fonts.css">
<link rel="stylesheet" type="text/css" href="/trip/assets/css/destination.css">
</head>

<body>

<div id="content_wrapper" class="adder">

<h2><?php echo $title; ?></h2><br><br>
<?php
if (!empty($destination_name))
{
	echo "<h3>";
	echo $destination_name;
	echo "</h3>";
}
if (!empty($info))
{
	echo "<p class='info'>";
	foreach ($info as $row)
	{
		echo $row;
		echo "<br>";
	}
	echo "</p>";
}
if (!empty($timestamp))
{
	echo '<p class="timestamp">';
	echo $timestamp;
	echo '</p>';
}
foreach ($links as $link)
{
?>
	<a class="backlink" href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a><br>
<?php
}
?>
</div>
</body>
</html>
