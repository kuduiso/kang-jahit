document.addEventListener('DOMContentLoaded', function() {
  let a = document.querySelectorAll('a');
  for (let i = 0; i < a.length; i++) {
    a[i].addEventListener("click", function() {
      let nav = a[i].hash.substr(1);
      loadPage(nav)
      goSection()
    })
  }

  // --- CEK PARAM
  const param = new URLSearchParams(window.location.search)
  const idParam = param.get("id")

  // --- GET HASH NAV
  let nav = window.location.hash.substr(1);
  if (nav == "" && idParam == null || idParam == "") {
    loadPage("home")
    goSection()
  } else if(nav == "home") {
    loadPage("home")
    goSection()
  } else if(nav == "order") {
    loadPage("order")
    goSection()
  } else if(nav == "list-order") {
    loadPage("list-order")
    goSection()
  } else if(nav == "about") {
    loadPage("about")
    goSection()
  } else if(nav == "" && idParam != "") {
    loadPage("update")
    goSection()
  }

  function loadPage(page) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4) {
        let content = document.querySelector('#content')
        if (this.status == 200) {
          content.innerHTML = xhttp.responseText;

          // === Fungsi Tambahan
          btnInsOrder()
          btnSimpan()
          btnUpdate()
          tampilData()
          showFormUpdate()

        } else if (this.status == 404) {
          content.innerHTML = '<h4>Halaman tidak ditemukan...</h4>'
        } else {
          content.innerHTML = '<h4>Halaman tidak dapat diakses ....</h4>'
        }
      }
    }
    if (sessionStorage.getItem("login")) {
      xhttp.open('GET', page+'.html', true);
      xhttp.send();
    } else {
      content.innerHTML = '<h4>Silahkan login dulu ....</h4>'
    }
  }

  function goSection() {
    document.querySelector('#content').scrollIntoView({
      behavior: 'smooth'
    })
  }

  // BUTTON INSERT ORDER
  function btnInsOrder() {
    let insert = document.querySelector('#insertOrder')
    if (insert != null) {
      insert.addEventListener('click', function() {
      let url = document.querySelector('#insertOrder').hash.substr(1)
      loadPage(url)
      })
    }
  }

  // BUTTON SIMPAN ORDER
  function btnSimpan() {
    let simpan = document.querySelector('#simpanOrder')
    if (simpan != null) {
      simpan.addEventListener('click', function() {
        // --- CEK FORM ORDER
          let nama = $("input[name='nama']")
          let keterangan = $("textarea[name='keterangan']")
          let tgl_masuk = $("input[name='tgl_masuk']")
          let tgl_jadi = $("input[name='tgl_jadi']")
          let err_box = $(".err-msg")
          // Nama
          if (nama.val() == "") {
            nama.addClass("border-red")
            err_box.eq(0).html("Nama harus diisi")
          } else {
            nama.removeClass("border-red")
            err_box.eq(0).html("")
          }
          // Keterangan
          if (keterangan.val() == "") {
            keterangan.addClass("border-red")
            err_box.eq(1).html("Keterangan harus diisi")
          } else {
            keterangan.removeClass("border-red")
            err_box.eq(1).html("")
          }
          // TGL_Masuk
          if (tgl_masuk.val() == "") {
            tgl_masuk.addClass("border-red")
            err_box.eq(2).html("Tanggal masuk harus diisi")
          } else {
            tgl_masuk.removeClass("border-red")
            err_box.eq(2).html("")
          }
          // TGL_Jadi
          if (tgl_jadi.val() == "") {
            tgl_jadi.addClass("border-red")
            err_box.eq(3).html("Tanggal jadi harus diisi")
          } else {
            tgl_jadi.removeClass("border-red")
            err_box.eq(3).html("")
          }
        if (nama.val() != "" && keterangan.val() != "" && tgl_masuk.val() != "" && tgl_jadi.val() != "") {
          // AJAX TO SIMPAN.PHP
          $.ajax({
            type: "post",
            url: "http://localhost/uasweb/simpan.php",
            contentType: false,
            cache: false,
            processData: false,
            data: new FormData($('#formOrder')[0]),
            dataType: 'json',
            success: function(data) {
              if (data.message != undefined) {
                alert(data.message);
              } else {
                alert(data.msg_error.file);
              }
            }
          })
          // END AJAX
        }

      })
    }
  }
  // END BTN SIMPAN

  // TAMPILKAN DATA DARI DATABASE
  function tampilData() {
    let isiOrder = document.querySelector("#data-order");
    if (isiOrder != null) {
        let dtOrder = ''

      // START AJAX
      $.ajax({
        type: 'get',
        url: 'http://localhost/uasweb/tampil.php',
        dataType: 'json',
        success: function(data) {
          // console.log(data);
          let nomor = 0;
          for(i in data.result) {
            nomor++;
            dtOrder +=
            `
            <tr>
              <td class="text-center">${nomor}</td>
              <td>${data.result[i].nama}</td>
              <td>${data.result[i].keterangan}</td>
              <td class="text-center">${data.result[i].tgl_masuk}</td>
              <td class="text-center">${data.result[i].tgl_jadi}</td>
              <td class="text-center"><a href="http://localhost/uasweb/assets/img/${data.result[i].referensi}" target="_blank" class="link-none btn-view">View</a></td>
              <td class="text-center"><a href="http://localhost/uasweb/?id=${data.result[i].id}" class="btn-edit link-none">Edit</a> <a href="javascript:void(0)" onclick="deleteData(${data.result[i].id}, '${data.result[i].referensi}')" class="btn-delete link-none">Delete</a></td>
            </tr>
            `
          }
          isiOrder.innerHTML = dtOrder;
        }

      })
      // END AJAX
    }
  }
  // END TAMPILKAN DATA DARI DATABASE

  // --- SHOW DATA ON FORM UPDATE
  function showFormUpdate() {
    let formUpdate = document.querySelector("#formUpdate")
    if (formUpdate != null) {
      // CEK PARAM
      const param = new URLSearchParams(window.location.search)
      const idParam = param.get("id")

      // VARIABEL - VARIABEL
      let id = $("input[name='id_akun']")
      let old_referensi = $("input[name='old_referensi']")
      let nama = $("input[name='nama']")
      let keterangan = $("textarea[name='keterangan']")
      let tgl_masuk = $("input[name='tgl_masuk']")
      let tgl_jadi = $("input[name='tgl_jadi']")
      let referensi = $(".img-referensi")

      // START AJAX
      $.ajax({
        type: 'get',
        url: 'http://localhost/uasweb/getbyid.php/?id='+idParam,
        dataType: 'json',
        success: function(data) {
          console.log(data.message)
          id.val(data.result.id)
          old_referensi.val(data.result.referensi)
          nama.val(data.result.nama)
          keterangan.val(data.result.keterangan)
          tgl_masuk.val(data.result.tgl_masuk)
          tgl_jadi.val(data.result.tgl_jadi)
          let imgRef =
          `
          <a href="http://localhost/uasweb/assets/img/${data.result.referensi}" target="_blank" class="link-none">
            <img src="http://localhost/uasweb/assets/img/${data.result.referensi}" alt="ref-foto">
          </a>
          <span class="text-12">${data.result.referensi}</span>
          `
          referensi.html(imgRef)
        }
      })
      // END AJAX
    }
  }

  // SIMPAN UPDATE
  function btnUpdate() {
    let formUpdate = $("#formUpdate")
    let referensi = $(".img-referensi")
    if (formUpdate != null) {
      $("#simpanUpdate").on("click", function(){
        // --- CEK FORM UPDATE
        let nama = $("input[name='nama']")
        let keterangan = $("textarea[name='keterangan']")
        let tgl_masuk = $("input[name='tgl_masuk']")
        let tgl_jadi = $("input[name='tgl_jadi']")
        let err_box = $(".err-msg")
        // Nama
        if (nama.val() == "") {
          nama.addClass("border-red")
          err_box.eq(0).html("Nama harus diisi")
        } else {
          nama.removeClass("border-red")
          err_box.eq(0).html("")
        }
        // Keterangan
        if (keterangan.val() == "") {
          keterangan.addClass("border-red")
          err_box.eq(1).html("Keterangan harus diisi")
        } else {
          keterangan.removeClass("border-red")
          err_box.eq(1).html("")
        }
        // TGL_Masuk
        if (tgl_masuk.val() == "") {
          tgl_masuk.addClass("border-red")
          err_box.eq(2).html("Tanggal masuk harus diisi")
        } else {
          tgl_masuk.removeClass("border-red")
          err_box.eq(2).html("")
        }
        // TGL_Jadi
        if (tgl_jadi.val() == "") {
          tgl_jadi.addClass("border-red")
          err_box.eq(3).html("Tanggal jadi harus diisi")
        } else {
          tgl_jadi.removeClass("border-red")
          err_box.eq(3).html("")
        }
        if (nama.val() != "" && keterangan.val() != "" && tgl_masuk.val() != "" && tgl_jadi.val() != "") {
          // START AJAX
          $.ajax({
            type: "post",
            url: "http://localhost/uasweb/simpanupdate.php",
            contentType: false,
            cache: false,
            processData: false,
            data: new FormData($("#formUpdate")[0]),
            dataType: 'json',
            success: function(data) {
              if (typeof data.result != "undefined") {
                let imgRef =
                `
                <a href="http://localhost/uasweb/assets/img/${data.result.referensi}" target="_blank" class="link-none">
                <img src="http://localhost/uasweb/assets/img/${data.result.referensi}" alt="ref-foto">
                </a>
                <span class="text-12">${data.result.referensi}</span>
                `
                referensi.html(imgRef)
                $("#file_ref").replaceWith($("#file_ref").val('').clone(true));
              }
              alert(data.message)
            }
          })
          // END AJAX
        }
      })
    }
  }
  // END SIMPAN UPDATE
})
