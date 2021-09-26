<?php

$user = 'root';
$pass = '';
$host = 'localhost';
$db = 'db_kangjahit';
$data = [];

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli -> connect_errno) {
  $data = [
    "message" => "Gagal terhubung database: ".$mysqli -> connect_error
  ];
  echo json_encode($data);
}
?>
