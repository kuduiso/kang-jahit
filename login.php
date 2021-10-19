<?php

require_once('koneksi.php');

$username = $_POST['username'];
$password = $_POST['password'];

$data_login = $mysqli->query('SELECT username, password FROM users')->fetch_assoc();
$login = [
  'login' => FALSE
];

if ($username === $data_login['username']) {
  if (md5($password) === $data_login['password']) {
      $login = [
        'login' => TRUE
      ];      
  }
}

echo json_encode($login);