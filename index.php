<?php
include 'header.php'; ?>
<style>
.dataTables_filter {
    margin-bottom: 10px;
}

</style>
<div class="container mt-4 py-5" id="halaman_container">
    <!-- Modal Add Data -->
    <div class="modal fade" id="addModalData" tabindex="-1" aria-labelledby="addModalDataLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addModalDataLabel"><i class="bi bi-file-earmark-plus"></i>
                        Tambah Data</h1>
                    <button type="button" id="addData" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="add-data-form" class="was-validated" method="POST" action="master_action.php"
                    enctype="multipart/form-data" novalidate>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <label for="formFileMultiple" class="form-label">Foto Pengenalan Wajah</label>
                                <div id="div_image" class="d-flex justify-content-center position-relative "
                                    style="overflow:hidden">
                                    <img id="tempat_image">
                                </div>
                                <div class="mb-3">
                                    <input type="file" class="form-control" aria-label="file example" name="files[]"
                                        id="file-input" multiple required>
                                    <div class="invalid-feedback">Foto wajib diisi!</div>
                                </div>
                                <p style="text-align : justify; font-size:10px" class="text-muted mb-3 mt-2">
                                    - Upload foto lebih dari 1.<br>
                                    - Klik gambar untuk menghapus gambar.</p>
                                <div class="mb-3">
                                    <div id="preview" class="d-flex justify-content-start">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="formFileMultiple" class="form-label">Data Diri</label>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">No.
                                    ID/KTP/KTA/DLL</span>
                                <input type="text" name="nomor_id" id="nomor_id" class="form-control"
                                    placeholder="No. ID/KTP/KTA/Dll" required>
                                <div class="invalid-feedback">Nomor ID wajib diisi!</div>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">Nama</span>
                                <input type="text" name="nama1" id="nama1" class="form-control" placeholder="Nama"
                                    required>
                                <div class="invalid-feedback">Nama wajib diisi!</div>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">Tempat
                                    Lahir</span>
                                <input type="text" name="tmpt_lhr1" id="tmpt_lhr1" class="form-control"
                                    placeholder="Tempat Lahir" required>
                                <div class="invalid-feedback">Tempat Lahir wajib diisi!</div>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">Tanggal
                                    Lahir</span>
                                <input type="date" name="tgl_lhr1" id="tgl_lhr1" class="form-control"
                                    placeholder="Tanggal Lahir" required>
                                <div class="invalid-feedback">Tanggal Lahir wajib diisi!</div>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">Jenis
                                    Kelamin</span>
                                <input type="text" name="kelamin1" id="kelamin1" class="form-control"
                                    placeholder="Jenis Kelamin" required>
                                <div class="invalid-feedback">Jenis Kelamin wajib diisi!</div>
                                <span style="text-align : justify; font-size:10px"
                                    class="text-muted mt-1">Pekerjaan</span>
                                <input type="text" name="pekerjaan1" id="pekerjaan1" class="form-control"
                                    placeholder="Pekerjaan" required>
                                <div class="invalid-feedback">Pekerjaan wajib diisi!</div>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">No
                                    HP</span>
                                <input type="text" name="no_hp1" id="no_hp1" class="form-control" placeholder="No HP"
                                    required>
                                <div class="invalid-feedback">No HP wajib diisi!</div>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">Email</span>
                                <input type="email" name="email1" id="email1" class="form-control" placeholder="Email"
                                    required>
                                <div class="invalid-feedback">Email wajib diisi dengan @webmail.com!!</div>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">Alamat</span>
                                <input type="text" name="alamat1" id="alamat1" class="form-control" placeholder="Alamat"
                                    required>
                                <div class="invalid-feedback">Alamat wajib diisi!</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Add Data" class="btn btn-success btn-block"
                            id="add-data-btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Add Data -- End -->
    <!-- Modal Edit Data -->
    <div class="modal fade" id="editModalData" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5"><i class="bi bi-pencil-square"></i> Edit
                        Data
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-data-form" class="p-2 was-validated" novalidate>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <label for="formFileMultiple" class="form-label">Foto
                                    Pengenalan Wajah</label>
                                <div class="mb-3">
                                    <input type="file" class="form-control" aria-label="file example" name="filesEdit[]"
                                        id="file-inputEdit" multiple>
                                </div>
                                <label for="formFileMultiple" class="form-label">
                                    Foto Baru</label>
                                <div class="mb-3">
                                    <div id="previewEdit" class="d-flex justify-content-start">
                                    </div>
                                </div>
                                <p style="text-align : justify; font-size:10px" class="text-muted mb-3 mt-2">
                                    - Upload foto lebih dari 1.<br>
                                    - Klik gambar untuk menghapus gambar.</p>
                                <label for="formFileMultiple" class="form-label">
                                    Foto Lama</label>
                                <div class="mb-3">
                                    <div id="previewLama" class="d-flex justify-content-start">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="formFileMultiple" class="form-label">Data
                                    Diri</label>
                                <div class="mb-3 d-flex justify-content-center">
                                    <div id="previewSingle" class=" col-md-6">
                                    </div>
                                </div>
                                <div>
                                    <input type="text" id="nomor_idEdit" name="nomor_idEdit"
                                        class="form-control-plaintext" required readonly>
                                    <p style="text-align : justify; font-size:10px" class="text-muted mt-2">
                                        Nomor ID tidak bisa dirubah</p>
                                </div>
                                <div class="mb-3">
                                    <span style="text-align : justify; font-size:10px"
                                        class="text-muted mt-1">Nama</span>
                                    <input type="hidden" name="id_orang" id="id_orang">
                                    <input type="text" id="namaEdit" name="namaEdit" class="form-control" required>
                                    <div class="invalid-feedback">Nama wajib diisi!</div>
                                </div>
                                <!----------- -->
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">Tempat
                                    Lahir</span>
                                <input type="text" name="tmpt_lhrEdit" id="tmpt_lhrEdit" class="form-control"
                                    placeholder="Tempat Lahir" required>
                                <div class="invalid-feedback">Tempat Lahir wajib diisi!</div>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">Tanggal
                                    Lahir</span>
                                <input type="date" name="tgl_lhrEdit" id="tgl_lhrEdit" class="form-control"
                                    placeholder="Tanggal Lahir" required>
                                <div class="invalid-feedback">Tanggal Lahir wajib diisi!</div>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">Jenis
                                    Kelamin</span>
                                <input type="text" name="kelaminEdit" id="kelaminEdit" class="form-control"
                                    placeholder="Jenis Kelamin" required>
                                <div class="invalid-feedback">Jenis Kelamin wajib diisi!</div>
                                <span style="text-align : justify; font-size:10px"
                                    class="text-muted mt-1">Pekerjaan</span>
                                <input type="text" name="pekerjaanEdit" id="pekerjaanEdit" class="form-control"
                                    placeholder="Pekerjaan" required>
                                <div class="invalid-feedback">Pekerjaan wajib diisi!</div>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">No
                                    HP</span>
                                <input type="text" name="no_hpEdit" id="no_hpEdit" class="form-control"
                                    placeholder="No HP" required>
                                <div class="invalid-feedback">No HP wajib diisi!</div>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">Email</span>
                                <input type="email" name="emailEdit" id="emailEdit" class="form-control"
                                    placeholder="Email" required>
                                <div class="invalid-feedback">Email wajib diisi dengan @webmail.com!</div>
                                <span style="text-align : justify; font-size:10px" class="text-muted mt-1">Alamat</span>
                                <input type="text" name="alamatEdit" id="alamatEdit" class="form-control"
                                    placeholder="Alamat" required>
                                <div class="invalid-feedback">Alamat wajib diisi!</div>
                                <!-- ------------ -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" name="submit" id="update-data-btn" value="Update"
                            class="btn btn-success btn-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit Data -- End -->
    <!-- Show Alert -->
    <div class="row">
        <div class="col-md-12">
            <h4>Input Data dengan Foto</h4>
            <hr>
        </div>
        <div class="col-lg-12">
            <div id="showAlert"></div>
        </div>
    </div>
    <!-- Show Alert End -->
    <!-- Button trigger modal -->
    <div class="d-flex justify-content-end">
        <button type="button" id="addDataModal" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#addModalData"><i class="bi bi-file-earmark-plus"></i>
            Tambah Data
        </button>
    </div>
    <div class="row mt-3" id="bodyTable">
    </div>
</div>
<script type="text/javascript">
//Sembunyikan data saat modal Edit hide
const editModal2 = document.getElementById('editModalData')
const editFormData1 = document.getElementById('edit-data-form')

editModal2.addEventListener('hide.bs.modal', function() {
    editFormData1.reset();
    //hapus img
    var imgElementsEdit = document.querySelectorAll(
        ".imageClass"); // HTMLCollection
    for (var i = 0; i < imgElementsEdit.length; i++) {
        var imgEdit = imgElementsEdit[i];
        imgEdit.parentNode.removeChild(imgEdit);
    }
    //hapus img selesai
})

//Sembunyikan data saat modal Add di hide
const addModal = document.getElementById('addModalData')
const addFormData1 = document.getElementById('add-data-form')

addModal.addEventListener('hide.bs.modal', function() {
    addFormData1.reset();
    //hapus img
    var imgElements = document.querySelectorAll(".imageClass"); // HTMLCollection
    for (var i = 0; i < imgElements.length; i++) {
        var img = imgElements[i];
        img.parentNode.removeChild(img);
    }
    //hapus img selesai
})

//hapus image saat klik saat input kosong
const inputAdd = document.getElementById("file-input");
inputAdd.addEventListener("input", function() {
    if (inputAdd.value.length === 0) {
        //hapus img
        var imgElements = document.querySelectorAll(
            ".imageClass"); // HTMLCollection
        for (var i = 0; i < imgElements.length; i++) {
            var img = imgElements[i];
            img.parentNode.removeChild(img);
        }
        //hapus img selesai
    }
});

//Preview multiple images Add mulai
let chooseFiles = document.getElementById("file-input");
let previewWrapper = document.getElementById("preview");

chooseFiles.addEventListener("change", (e) => {
    [...e.target.files].forEach(showFiles);
});

function hapusGambar() {
    let nodes = document.querySelectorAll('.imageClass')
    for (let i = 0, j = nodes.length; i < j; i++) {
        nodes[i].remove()
    }
}

function resetFileInput() {
    chooseFiles.value = ""
}

function showFiles(file) {
    if (!/\.(jpg)$/i.test(file.name)) {
        hapusGambar()
        resetFileInput()
        return Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'File : ' + file.name + ' invalid.'
        });
    }
    var div = document.createElement("div")
    div.classList.add("d-flex");
    div.classList.add("justify-content-center");
    div.classList.add("position-relative");
    div.style.overflow = "hidden";
    let previewImage = new Image();
    previewImage.dataset.name = file.name;
    previewImage.classList.add("img");
    previewImage.classList.add("imageClass", "img-fluid");
    previewImage.src = URL.createObjectURL(file);
    previewImage.height = 100;
    previewImage.width = 100;
    div.append(previewImage); // append preview image
    previewWrapper.append(div); // append preview image

    // -- remove the image preview visually    
    document.querySelectorAll(".img").forEach((i) => {
        i.addEventListener("click", (e) => {
            const transfer = new DataTransfer();
            const name = e.target.dataset.name;

            for (const file of chooseFiles.files) {
                if (file.name !== name) {
                    transfer.items.add(file);
                }
            }

            chooseFiles.files = transfer.files;
            e.target.remove();
        });
    });
}

//Preview multiple images Edit mulai
let chooseFilesEdit = document.getElementById("file-inputEdit");
let previewWrapperEdit = document.getElementById("previewEdit");

chooseFilesEdit.addEventListener("change", (e) => {
    [...e.target.files].forEach(showFilesEdit);
});

function hapusGambarEdit() {
    chooseFilesEdit.value = ""
    let nodes = document.querySelectorAll('#previewEdit')
    for (let i = 0, j = nodes.length; i < j; i++) {
        nodes[i].remove()
    }
}

function resetFileInputEdit() {
    chooseFilesEdit.value = ""
}

function showFilesEdit(file) {
    if (!/\.(jpg)$/i.test(file.name)) {
        //hapus image
        //hapusGambarEdit()
        //hapus input value
        resetFileInputEdit()
        return Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'File : ' + file.name + ' invalid.'
        });
    }
    var div = document.createElement("div")
    div.classList.add("d-flex");
    div.classList.add("justify-content-center");
    div.classList.add("position-relative");
    div.style.overflow = "hidden";
    let previewImageEdit = new Image();
    previewImageEdit.dataset.name = file.name;
    previewImageEdit.classList.add("img");
    previewImageEdit.classList.add("imageClass", "img-fluid");
    //previewImageEdit.classList.add("img-fluid");
    previewImageEdit.src = URL.createObjectURL(file);
    previewImageEdit.height = 100;
    previewImageEdit.width = 100;
    div.append(previewImageEdit); // append preview image
    previewWrapperEdit.append(div); // append preview image

    // -- remove the image preview visually    
    document.querySelectorAll(".img").forEach((i) => {
        i.addEventListener("click", (e) => {
            const transfer = new DataTransfer();
            const name = e.target.dataset.name;

            for (const file of chooseFilesEdit.files) {
                if (file.name !== name) {
                    transfer.items.add(file);
                }
            }
            chooseFilesEdit.files = transfer.files;
            e.target.remove();
        });
    });
}
</script>
<script src="crud.js"></script>
