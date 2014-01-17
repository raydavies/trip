<?php
include_once(BASEPATH.'/models/postcardmodel.php');

$postcard = new Postcard;
$postcard->send_postcard();
?>
