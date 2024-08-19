<?php
include 'header.php'; ?>
<div class="container py-5 mt-4">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <h4>Percarian Data dengan Foto</h4>
            <hr>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="alert alert-primary text-center fw-bold" role="alert" id="tulisan_silahkan">
                    </div>
                    <div class="mb-3 input-group  input-group-sm">
                        <input type="file" name="pic" id="imageUpload" class="form-control col-md-6">
                    </div>
                    <div class="preview mb-3 bersihkanClass2" id="im_preview">
                    </div>
                    <!-- <div id="tulisan"></div> -->
                </div>
            </div>
        </div>
        <div class="col-md-3  mb-2">
            <div class="card">
                <div class="card-body" id="tempatFoto">
                    <div id="tempat_alert" class="tempat_alertClass"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4  mb-2">
            <div class="card">
                <div class="card-body">
                    <label class="text-primary"><strong>Nama :</strong></label>
                    <div id="nama_hasil"></div>
                    <label class="text-primary"><strong>Tempat Lahir :</strong></label>
                    <div id="tmpt_lhr_hasil"></div>
                    <label class="text-primary"><strong>Tanggal Lahir :</strong></label>
                    <div id="tgl_lhr_hasil"></div>
                    <label class="text-primary"><strong>Jenis Kelamin :</strong></label>
                    <div id="kelamin_hasil"></div>
                    <label class="text-primary"><strong>Pekerjaan :</strong></label>
                    <div id="pekerjaan_hasil"></div>
                    <label class="text-primary"><strong>No. HP :</strong></label>
                    <div id="no_hp_hasil"></div>
                    <label class="text-primary"><strong>Email :</strong></label>
                    <div id="email_hasil"></div>
                    <label class="text-primary"><strong>Alamat :</strong></label>
                    <div id="alamat_hasil"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="container d-flex align-items-center justify-content-center">
</div> -->
<script defer src="script.js"></script>
</body>
</html>
