<?php
date_default_timezone_set('America/Chicago');

$config['production']['host'] = 'localhost';
$config['production']['username'] = 'mumbles_jordan';
$config['production']['password'] = 'icedm1lk';
$config['production']['global_db'] = 'mumbles_trip';
$config['production']['getter'] = 'mumbles_getter';
$config['production']['getpw'] = 'Hyp3rDr1v3!';

$config['development']['host'] = 'localhost';
$config['development']['username'] = 'root';
$config['development']['password'] = 'icedm1lk';
$config['development']['global_db'] = 'mumbles_trip';
$config['development']['getter'] = 'root';
$config['development']['getpw'] = 'icedm1lk';


$config = $config['production'];
