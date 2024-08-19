<?php
require_once 'master_koneksi.php';

class Database extends koneksi
{
    //Update Data Orang, kalau image ada
    function update_orang($dataOrang)
    {
        $id = $dataOrang['id_orang'];
        //$nomor_id = $this->con->real_escape_string($dataOrang['nomor_id']);
        $nama = $this->con->real_escape_string($dataOrang['nama']);

        $tmpt_lhr = $this->con->real_escape_string($dataOrang['tmpt_lhrEdit']);
        $tgl_lhr = $this->con->real_escape_string($dataOrang['tgl_lhrEdit']);
        $kelamin = $this->con->real_escape_string($dataOrang['kelaminEdit']);
        $pekerjaan = $this->con->real_escape_string(
            $dataOrang['pekerjaanEdit']
        );
        $no_hp = $this->con->real_escape_string($dataOrang['no_hpEdit']);
        $email = $this->con->real_escape_string($dataOrang['emailEdit']);
        $alamat = $this->con->real_escape_string($dataOrang['alamatEdit']);

        return $this->con->query(
            "UPDATE data_orang SET nama='$nama', tmpt_lhr='$tmpt_lhr', tgl_lhr='$tgl_lhr', kelamin='$kelamin', pekerjaan='$pekerjaan', no_hp='$no_hp', email='$email', alamat='$alamat' WHERE id_orang='$id'"
        );
    }

    //Update Data Orang, kalau image tidak ada
    public function update_data_orang($data)
    {
        $id_orang = $data['id_orang'];
        //$nomor_id = $this->con->escape_string($data['nomor_id']);
        $nama = $this->con->escape_string($data['nama']);

        $tmpt_lhr = $this->con->real_escape_string($data['tmpt_lhrEdit']);
        $tgl_lhr = $this->con->real_escape_string($data['tgl_lhrEdit']);
        $kelamin = $this->con->real_escape_string($data['kelaminEdit']);
        $pekerjaan = $this->con->real_escape_string($data['pekerjaanEdit']);
        $no_hp = $this->con->real_escape_string($data['no_hpEdit']);
        $email = $this->con->real_escape_string($data['emailEdit']);
        $alamat = $this->con->real_escape_string($data['alamatEdit']);

        $query = $this->con->query(
            "UPDATE data_orang SET nama='$nama', tmpt_lhr='$tmpt_lhr', tgl_lhr='$tgl_lhr', kelamin='$kelamin', pekerjaan='$pekerjaan', no_hp='$no_hp', email='$email', alamat='$alamat' WHERE id_orang='$id_orang'"
        );
        return $query;
    }

    //Update Data nomor ID foto di tabel foto
    public function update_tabel_foto($data)
    {
        $id_orang = $data['id_orang'];
        $nomor_id = $this->con->escape_string($data['nomor_id']);

        $query = $this->con->query(
            "UPDATE foto SET nomor_id_foto='$nomor_id' WHERE orang_id='$id_orang'"
        );
        return $query;
    }

    // Ambil Data Single dari Database
    public function readOneBasedLabel($id)
    {
        $query = $this->con->query(
            "SELECT * FROM data_orang WHERE nomor_id ='$id'"
        );
        return $query->fetch_object();
    }

    // Ambil Data Single dari Database
    public function readOne($id)
    {
        $query = $this->con->query(
            "SELECT * FROM data_orang WHERE id_orang ='$id'"
        );
        return $query->fetch_object();
    }

    // Ambil Data Image dari Database
    public function readImage($id)
    {
        //Ambil dari tabel foto dengan id yg sama
        $query = $this->con->query(
            "SELECT * FROM view_foto WHERE nomor_id_foto='$id'"
        );
        return $query->fetch_object();
    }

    // Ambil semua data dari database tabel data_orang
    public function data_semua()
    {
        $query = $this->con->query(
            'SELECT * FROM data_orang ORDER BY tgl_input DESC'
        );
        return $query;
    }

    //Tambah Data Foto
    function tambah_foto($insertValuesSQL)
    {
        return $this->con->query(
            "INSERT INTO foto (orang_id,nomor_id_foto,nama_foto, uploaded_on) VALUES $insertValuesSQL"
        );
    }
    //Tambah Data Orang
    function tambah_orang($data)
    {
        $foto_single = $data['foto_single'];
        $nomor_id = $this->con->real_escape_string($data['nomor_id']);
        $nama = $this->con->real_escape_string($data['nama']);
        $tmpt_lhr = $this->con->real_escape_string($data['tmpt_lhr']);
        $tgl_lhr = $data['tgl_lhr'];
        $kelamin = $this->con->real_escape_string($data['kelamin']);
        $pekerjaan = $this->con->real_escape_string($data['pekerjaan']);
        $no_hp = $this->con->real_escape_string($data['no_hp']);
        $email = $this->con->real_escape_string($data['email']);
        $alamat = $this->con->real_escape_string($data['alamat']);

        return $this->con->query(
            "INSERT INTO data_orang (image_single,nomor_id,nama,tmpt_lhr,tgl_lhr,kelamin,pekerjaan,no_hp,email,alamat) VALUES('$foto_single','$nomor_id','$nama','$tmpt_lhr','$tgl_lhr','$kelamin','$pekerjaan','$no_hp','$email','$alamat')"
        );
    }

    //ambil data utk face reco
    function tampil_folder_array()
    {
        $result = $this->con->query('SELECT * FROM data_orang');
        return $result;
    }

    // Hapus Data dari Database & hapus folder image
    public function delete($id)
    {
        $ambil_folder = $this->ambil_folder($id);
        $folder_gambar = 'assets/labeled_images/';
        $folder_gambar_file = $folder_gambar . $ambil_folder['nomor_id'];
        array_map('unlink', glob("$folder_gambar_file/*.*"));
        rmdir($folder_gambar . $ambil_folder['nomor_id']);

        $hapus_data_foto = $this->con->query(
            "DELETE FROM foto WHERE orang_id='$id' "
        );

        if ($hapus_data_foto) {
            $hapus = $this->con->query(
                "DELETE FROM data_orang WHERE id_orang='$id' "
            );
        }

        return $hapus;
    }

    //Ambil folder
    public function ambil_folder($id)
    {
        $folder = $this->con->query(
            "SELECT * FROM data_orang WHERE id_orang='$id'"
        );
        return $folder->fetch_array();
    }

    //Ambil Nomor ID
    public function ambil_nomor_id($id)
    {
        $folder = $this->con->query(
            "SELECT data_orang.nomor_id FROM data_orang WHERE nomor_id='$id'"
        );
        return $folder;
    }
    //Ambil Orang
    public function ambil_id_orang($id)
    {
        $folder = $this->con->query(
            "SELECT data_orang.id_orang FROM data_orang WHERE id_orang='$id'"
        );
        return $folder->fetch_array();
    }

    //Hapus Data Loop di Tabel foto
    public function hapus_data_loop($id)
    {
        $folder = $this->con->query("DELETE FROM foto WHERE orang_id='$id' ");
        //hapus file image di folder
        $ambil_folder = $this->ambil_folder($id);
        $folder_gambar = 'assets/labeled_images/';
        $folder_gambar_file = $folder_gambar . $ambil_folder['nomor_id'];
        array_map('unlink', glob("$folder_gambar_file/*.*"));
        //ambil nilai folder
        return $folder;
    }

    //Ambil nomor ID
    //koding masih kosong
}

?>
