<?php


require_once 'DbOperations.php';

$response = array();

$db = new DbOperations();

$db->logout();

header("Location: http://localhost/skel/index.php");
exit();
