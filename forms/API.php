<?php

include("forms/class.php");

$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

$name[0] = $data['name'];
echo json_encode($name);
?>
