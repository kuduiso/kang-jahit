<?php

require_once('koneksi.php');

$id = $_GET['id'];

$ambilData = "SELECT * FROM data_order WHERE id = $id";
$result = $mysqli->query($ambilData);
$ls_order = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $ls_order = [
      "id" => $row["id"],
      "nama" => $row["nama"],
      "keterangan" => $row["keterangan"],
      "tgl_masuk" => $row["tgl_masuk"],
      "tgl_jadi" => $row["tgl_jadi"],
      "referensi" => $row["referensi"]
    ];
  }

  $data = [
    "message" => "Berhasil ditampilkan",
    "result" => $ls_order
  ];

  header("Content-Type: application/json");
  echo json_encode($data);
  return;
} else {
  $data = [
    "message" => "data gagal ditampilkan"
  ];
  header("Content-Type: application/json");
  echo json_encode($data);
}

?>
