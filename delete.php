<?php

require_once("koneksi.php");

$id = $_GET["id"];
$img = $_GET["img"];
$path_img = realpath("./assets/img/{$img}");

$delete = "DELETE FROM data_order WHERE id = $id";
$result = $mysqli->query($delete);

// REMOVE IMAGES FROM STORAGE
$remove_img = unlink($path_img);

if ($remove_img) {
  $delete = "DELETE FROM data_order WHERE id = $id";
  $result = $mysqli->query($delete);
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
