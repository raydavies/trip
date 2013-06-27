<?php
if (!isset($_SESSION))
{
	session_start();
	$_SESSION['http_referer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}
ob_flush();

if (isset($_SESSION['username']))
{
	if (!empty($_POST))
	{
		$name = trim($_POST['reviewer']);
		$destination = $_POST['destination'];
		$review = trim($_POST['review_text']);

		if (!empty($_POST['score']))
		{
			$score = $_POST['score'];
		}
		else
		{
			$score = null;
		}
	}

	if (empty($review) || empty($name) || empty($destination))
	{
		$page->title = 'Submit Error';
		$title = 'Submission Error!';
		$info = array('There was an error in submitting your review. Please click the link below to go back and try again.');
		$links = array();
		$links[] = array('url'=>'../reviews/','title'=>'Back to Review');
		$links[] = array('url'=>'/'.$page->site_url.'/admin/','title'=>'Admin Options');
	}
	else
	{
		$name = mysqli_real_escape_string($link,$name);
		$review = mysqli_real_escape_string($link,$review);

		$query = "SELECT userid FROM ".$page->global_db.".users 
				WHERE username='".$name."' LIMIT 1";
		$result = $page->db->query($query);
		if ($result && $result->num_rows() == 1)
		{
			$row = $result->fetch_assoc();
			$userid = $row['userid'];
			$page->db->free_result();
		}

		$query = "SELECT destination_name FROM ".$page->global_db.".destinations WHERE destination_id='".$destination."'";
		$result = $page->db->query($query);
		if ($result && $result->num_rows())
		{
			while ($row = $page->db->fetch_assoc())
			{
				$destination_name = $row['destination_name'];
			}
			$page->db->free_result();
		}

		$query = "SELECT * FROM ".$page->site_db.".reviews 
				WHERE userid='".$userid."' AND destination_id='".$destination."'";
		$result = $page->db->query($query);
		if ($result && $result->num_rows())
		{
			while($row = $page->db->fetch_assoc())
			{
				if ($row != null)
				{
					$query = "UPDATE ".$page->site_db.".reviews 
							SET review='".$review."', score='".$score."' 
							WHERE destination_id='".$destination."'";
					$result = $page->db->query($query);
				}
				else
				{
					$query = "INSERT INTO ".$page->site_db.".reviews(userid,destination_id,review,score) VALUES ('".$userid."','".$destination."','".$review."','".$score."')";
					$result = $page->db->query($query);
				}
			}
			$page->db->free_result();

			if ($result)
			{
				$page->title = 'Success!';
				$title = 'Review Added!';
				$info = array($score." star(s)", stripslashes($review));
				$timestamp = "Submitted by ".ucwords($name)." at ".date('g:ia');
				$links = array();
				$links[] = array('url'=>'../reviews/','title'=>'Review Another Destination');
				$links[] = array('url'=>'/'.$page->site_url.'/admin/','title'=>'Admin Options');
			}
			else
			{
				$page->title = 'Submit Error';
				$title = 'Submission Error!';
				$info = array('There was an error in submitting your review. Please click the link below to go back and try again.');
				$links = array();
				$links[] = array('url'=>'../reviews/','title'=>'Back to Review');
				$links[] = array('url'=>'/'.$page->site_url.'/admin/','title'=>'Admin Options');
			}
		}
	}
	include_once(VIEWPATH.'/admin/review_handler.php');
}
else
{
	header("Location: /".$page->site_url."/admin/login/");
	die;
}
?>



