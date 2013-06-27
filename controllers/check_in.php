<?php
if (isset($_POST['location_id'], $_POST['user_id']))
{
	$sql = "INSERT INTO ".$page->global_db.".check_ins (location_id, user_id, epoch) VALUES (".$_POST['location_id'].", ".$_POST['user_id'].", UNIX_TIMESTAMP(NOW()))";
	$result = $page->db->query($sql);
	echo $result;
}
?>
