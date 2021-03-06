<?php

require_once("koneksi.php");

$id = $_GET["id"];
$img = $_GET["img"];
$path_img = realpath("./assets/img/{$img}");

// REMOVE IMAGES FROM STORAGE
$remove_img = unlink($path_img);

if ($remove_img) {
  $delete = $mysqli->prepare("DELETE FROM data_order WHERE id = ?");
  $delete->bind_param('i', $id);
  $result = $delete->execute();
  if ($result) {
    $data = [
      "message" => "Berhasil dihapus {$img}",
    ];
    header("Content-Type: application/json");
    echo json_encode($data);
  }
} else {
  $data = [
    "message" => "Gagal dihapus"
  ];
  header("Content-Type: application/json");
  echo json_encode($data);
}

?>
