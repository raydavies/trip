<?php

unset($_SESSION['username']);
session_destroy();

header("Location: /".$page->site_url."/");
die;
?>
