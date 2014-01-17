<?php
$query = "SELECT state FROM ".$page->global_db.".cities WHERE city = '".$_GET['city']."' LIMIT 1";
$result = $page->db->query($query);
if ($result && $result->num_rows)
{
	$row = $result->fetch_assoc();
	echo $row['state'];
	$result->free_result();
}
echo null;
?>
