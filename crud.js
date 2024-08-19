/** @format */
const editModal = new bootstrap.Modal(document.getElementById("editModalData"));
const updateFormData = document.getElementById("edit-data-form");
const addFormData = document.getElementById("add-data-form");
const addModalData = new bootstrap.Modal(
  document.getElementById("addModalData")
);

var tbody = document.querySelector("tbody");

function load(target, url) {
  var r = new XMLHttpRequest();
  r.open("GET", url, true);
  r.onreadystatechange = function () {
    if (r.readyState != 4 || r.status != 200) return;
    target.innerHTML = r.responseText;
    //ini untuk datatable -> perlu jquery
    $("#table_id").DataTable();
    //===
    var tbody = document.querySelector("tbody");
    //===

    //Edit Data
    tbody.addEventListener("click", (e) => {
      if (e.target && e.target.matches("a.editLink")) {
        e.preventDefault();
        let id = e.target.getAttribute("id");
        editData(id);
      }
    });

    const editData = async (id) => {
      //ambil data string
      const data = await fetch(`master_action.php?edit=1&id=${id}`, {
        method: "GET",
      });
      const response = await data.text();
      const res = JSON.parse(response);
      document.getElementById("id_orang").value = res.id_orang;
      document.getElementById("nomor_idEdit").value = res.nomor_id;

      document.getElementById("namaEdit").value = res.nama;
      document.getElementById("tmpt_lhrEdit").value = res.tmpt_lhr;
      document.getElementById("tgl_lhrEdit").value = res.tgl_lhr;
      document.getElementById("kelaminEdit").value = res.kelamin;
      document.getElementById("pekerjaanEdit").value = res.pekerjaan;
      document.getElementById("no_hpEdit").value = res.no_hp;
      document.getElementById("emailEdit").value = res.email;
      document.getElementById("alamatEdit").value = res.alamat;

      //folder
      const nama_folder = res.nomor_id;
      const nomor_id_foto = res.nomor_id;
      //buat img src
      const imSingle = res.image_single;
      console.log(imSingle);
      //=======

      //Ajax untuk ambil image
      const request = new XMLHttpRequest();
      request.open("GET", `master_action.php?image=${nomor_id_foto}`, false); // `false` makes the request synchronous
      request.send(null);

      if (request.status == 200) {
        const resimage1 = request.responseText;
        const resimage2 = JSON.parse(resimage1);
        const resimage3 = resimage2.nama_foto;
        const resimage = resimage3.split(" ");
        //console.log(resimage);
        //Buat preview multiple
        var preview2 = document.querySelector("#previewLama");
        for (let i = 0; i < resimage.length; i++) {
          console.log(resimage[i]);
          var div = document.createElement("div");
          div.classList.add(
            "d-flex",
            "justify-content-center",
            "position-relative"
          );
          div.style.overflow = "hidden";
          var image = new Image();
          image.width = 100;
          image.height = 100;
          image.classList = "imageClass";
          image.title = resimage[i];
          image.src =
            "assets/labeled_images/" + nama_folder + "/" + resimage[i];
          div.append(image);
          preview2.appendChild(div);
        }
        //Buat preview Single
        var previewSingle = document.querySelector("#previewSingle");
        var divSingle = document.createElement("div");
        var imageSingle = new Image();
        imageSingle.height = 200;
        imageSingle.classList.add("imageClass", "img-fluid");
        imageSingle.title = imSingle;
        imageSingle.src =
          "assets/labeled_images/" + nama_folder + "/" + imSingle;
        divSingle.append(imageSingle);
        previewSingle.appendChild(divSingle);
      }
    };

    // Delete User Ajax Request
    tbody.addEventListener("click", (e) => {
      if (e.target && e.target.matches("a.deleteLink")) {
        e.preventDefault();
        let id = e.target.getAttribute("id");
        deleteUser(id);
      }
    });

    const deleteUser = async (id) => {
      const data = await fetch(`master_action.php?delete=1&id=${id}`, {
        method: "GET",
      });

      load(document.getElementById("bodyTable"), "index_table.php");
      Swal.fire({
        icon: "success",
        title: "Berhasil",
        text: "Data berhasil dihapus !",
        showConfirmButton: false,
        timer: 1500,
      });
    };
  };
  r.send();
}
load(document.getElementById("bodyTable"), "index_table.php");

// Update User Ajax Request
updateFormData.addEventListener("submit", async (e) => {
  e.preventDefault();
  const filesU = document.querySelector("[type=file]").files;
  const formDataU = new FormData(updateFormData);
  formDataU.append("update", 1);

  for (let i = 0; i < filesU.length; i++) {
    formDataU.append(filesU[i].name, filesU[i]);
  }

  console.log(formDataU);

  if (updateFormData.checkValidity() === false) {
    e.preventDefault();
    e.stopPropagation();
    updateFormData.classList.add("was-validated");
    return false;
  } else {
    document.getElementById("update-data-btn").value = "Please Wait...";

    const dataU = await fetch("master_action.php", {
      method: "POST",
      body: formDataU,
    });
    const response = await dataU.text();
    console.log(response);
    showAlert.innerHTML = response;
    document.getElementById("update-data-btn").value = "Update";
    updateFormData.reset();
    updateFormData.classList.remove("was-validated");
    editModal.hide();

    load(document.getElementById("bodyTable"), "index_table.php");
    Swal.fire({
      icon: "success",
      title: "Berhasil...",
      text: "Data berhasil diupdate !",
      showConfirmButton: false,
      timer: 1500,
    });
  }
});

//Tambah Data
addFormData.addEventListener("submit", async (e) => {
  e.preventDefault();
  const files = document.querySelector("[type=file]").files;
  const formData = new FormData(addFormData);
  formData.append("add", 1);

  for (let i = 0; i < files.length; i++) {
    formData.append(files[i].name, files[i]);
  }

  if (files !== "") {
    if (addFormData.checkValidity() === false) {
      e.preventDefault();
      e.stopPropagation();
      addFormData.classList.add("was-validated");
      return false;
    } else {
      document.getElementById("add-data-btn").value = "Please Wait...";

      const data = await fetch("master_action.php", {
        method: "POST",
        body: formData,
      });
      const response = await data.text();
      //showAlert.innerHTML = response;
      const ToastMessage = response;
      if (response == "ID dobel") {
        Swal.fire({
          icon: "error",
          title: "Opsss....",
          text: "No ID tidak boleh dobel !",
        });
      } else {
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
          },
        });

        Toast.fire({
          icon: "success",
          title: "Data Berhasil ditambahkan",
        });
      }
      document.getElementById("add-data-btn").value = "Add Data";
      addFormData.reset();
      addFormData.classList.remove("was-validated");
      addModalData.hide();

      //hapus img
      var imgElements = document.querySelectorAll("img"); // HTMLCollection
      for (var i = 0; i < imgElements.length; i++) {
        var img = imgElements[i];
        img.parentNode.removeChild(img);
      }
      //ambil semua data
      load(document.getElementById("bodyTable"), "index_table.php");
    }
  }
});
