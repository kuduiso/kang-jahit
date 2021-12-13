<?php

require_once('koneksi.php');

// VARIABEL-VARIABEL
$nama = $_POST['nama'];
$keterangan = $_POST['keterangan'];
$tgl_masuk = $_POST['tgl_masuk'];
$tgl_jadi = $_POST['tgl_jadi'];
$id = $_POST['id_akun'];
$old_referensi = $_POST['old_referensi'];

// ==== HANDLING FILE =====
$lokasi = "assets/img/";
$oldName = $_FILES['file_ref']['name'];

if ($oldName != "") {
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
        "message" => "Format yang diizinkan jpg, jpeg dan png. Ukuran maksimum 300KB"
      ];
      header("Content-Type: application/json");
      echo json_encode($data);
      return;
    } else {
      if (move_uploaded_file($_FILES['file_ref']['tmp_name'], $uploadFile)) {
        // HAPUS FILE LAMA
        unlink($lokasi.$old_referensi);

        // JALANKAN QUERY DB - MENGUBAH GAMBAR
        // QUERY SIMPAN
        $ubah = $mysqli->prepare("UPDATE data_order SET nama= ?,keterangan= ?,tgl_masuk= ?,tgl_jadi= ?,referensi= ? WHERE id = ?");
        $ubah->bind_param('sssssi', $nama, $keterangan, $tgl_masuk, $tgl_jadi, $newName, $id);
        $result = $ubah->execute();

        // SIMPAN KE DB
        if ($result) {
          $data = [
            "message" => "berhasil diubah",
            "result" => [
              "referensi" => $newName
            ]
          ];
          header("Content-Type: application/json");
          echo json_encode($data);
          return;
        } else {
          $data = [
            "message" => "gagal diubah"
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
} else {
  // JALANKAN QUERY DB - TIDAK MENGUBAH GAMBAR
  // QUERY SIMPAN
  $ubah = $mysqli->prepare("UPDATE data_order SET nama= ?,keterangan= ?,tgl_masuk= ?,tgl_jadi= ? WHERE id = ?");
  $ubah->bind_param('ssssi', $nama, $keterangan, $tgl_masuk, $tgl_jadi, $id);
  $result = $ubah->execute();

  // SIMPAN KE DB
  if ($result) {
    $data = [
      "message" => "berhasil diubah",
      "result" => [
        "referensi" => $old_referensi
      ]
    ];
    header("Content-Type: application/json");
    echo json_encode($data);
    return;
  } else {
    $data = [
      "message" => "gagal diubah"
    ];
    header("Content-Type: application/json");
    echo json_encode($data);
    return;
  }
  // END QUERY DB
}

// ==== END HANDLING FILE =====

?>
