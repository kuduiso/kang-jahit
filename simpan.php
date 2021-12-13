<?php

require_once('koneksi.php');

// VARIABEL-VARIABEL
$nama = $_POST['nama'];
$keterangan = $_POST['keterangan'];
$tgl_masuk = $_POST['tgl_masuk'];
$tgl_jadi = $_POST['tgl_jadi'];

// ==== HANDLING FILE =====
$lokasi = "assets/img/";
$oldName = $_FILES['file_ref']['name'];
$uploadOk = 0;
$imgType = strtolower(pathinfo($oldName, PATHINFO_EXTENSION));
$newName = round(microtime(true)).".".$imgType;
$uploadFile = $lokasi.basename($newName);
$size = $_FILES['file_ref']['size'];

  // FORMAT YANG DIIZINKAN PNG/JPG/JPEG
  if ($imgType === "jpg" || $imgType === "png" || $imgType === "jpeg") {
    // FILE SIZE UNDER 300KB
    // FORMAT YANG DIIZINKAN PNG/JPG/JPEG
    if ($size < 1024*300) {
      $uploadOk = 1;
    }
  }

  // Check UPLOAD STATUS
  if ($uploadOk == 0) {
    $data = [
      "msg_error" =>
      [
        "file" => "Format yang diizinkan jpg, jpeg dan png. Maksimum ukuran 300KB {$imgType}"
      ]
    ];
    header("Content-Type: application/json");
    echo json_encode($data);
    return;
  } else {
    if (move_uploaded_file($_FILES['file_ref']['tmp_name'], $uploadFile)) {
      // JALANKAN QUERY DB
      // QUERY SIMPAN
      $simpan = $mysqli->prepare("INSERT INTO data_order(nama, keterangan, tgl_masuk, tgl_jadi, referensi) VALUES (?, ?, ?, ?, ?)");
      $simpan->bind_param('sssss',$nama, $keterangan, $tgl_masuk, $tgl_jadi, $newName);
      $result = $simpan->execute();

      // SIMPAN KE DB
      if ($result) {
        $data = [
          "message" => "berhasil disimpan"
        ];
        header("Content-Type: application/json");
        echo json_encode($data);
        return;
      } else {
        $data = [
          "message" => "gagal disimpan"
        ];
        header("Content-Type: application/json");
        echo json_encode($data);
        return;
      }
      // END QUERY DB
    } else {
      $data = [
        "msg_error" =>
        [
          "file" => "Terjadi kesalahan saat upload file"
        ]
      ];
      header("Content-Type: application/json");
      echo json_encode($data);
      return;
    }
  }
// ==== END HANDLING FILE =====

?>
