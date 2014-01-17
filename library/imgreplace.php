<?php
function img_replace()
{
	@$link = mysqli_connect('localhost','mumbles_jordan','icedm1lk','mumbles_trip') or die("Could not connect (".mysqli_connect_errno()."): ".mysqli_connect_error());
	$query = "SELECT destination_id,img_url FROM destinations";
	@$result = mysqli_query($link,$query) or die("MySQL error (".mysqli_errno($link)."): ".mysqli_error($link));
	$images = array();
	while ($row = $result->fetch_assoc())
	{
		$images[] = array('id'=>$row['destination_id'], 'url'=>$row['img_url']);
	}
	$result->free_result();
	if (!empty($images))
	{
		foreach ($images as $img)
		{
			if (empty($img['url']))
			{
				continue;
			}
			$url = str_replace('http://mumblecrumblydesign.com/besties/img/venue/', '', $img['url']);
			$query = "UPDATE destinations SET img_url = '".$url."' WHERE destination_id = ".$img['id'];
			@$result = mysqli_query($link,$query) or die("MySQL error (".mysqli_errno($link)."): ".mysqli_error($link));
			echo $img['url']." => ".$url."<br>";
		}
	}
	echo "Done";
}

img_replace();
?>
