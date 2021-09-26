<?php

require_once('koneksi.php');

$tampil = "SELECT * FROM data_order";
$result = $mysqli->query($tampil);

if ($result->num_rows > 0) {
  $angka = 0;
  $ls_order = [];
  while ($row = $result->fetch_assoc()) {
    $ls_order[$angka] = [
      "id" => $row["id"],
      "nama" => $row["nama"],
      "keterangan" => $row["keterangan"],
      "tgl_masuk" => $row["tgl_masuk"],
      "tgl_jadi"  => $row["tgl_jadi"],
      "referensi" => $row["referensi"]
    ];
    $angka++;
  }

  $data = [
    "message" => "data berhasil ditampilkan",
    "result" => $ls_order
  ];
  header('Content-Type: application/json');
  echo json_encode($data);
} else {
  $data = [
    "message" => "data gagal ditampilkan"
  ];
  header('Content-Type: application/json');
  echo json_encode($data);
}

?>
