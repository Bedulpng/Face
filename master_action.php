<?php
//hapus cache
header('Clear-Site-Data: "cache"');

require_once 'master_db.php';
require_once 'master_util.php';

$db = new Database();
$util = new Util();

//Cari Face untuk ambil Data
if (isset($_GET['search_face'])) {
    $id = $_GET['search_face'];
    $data = $db->readOneBasedLabel($id);
    echo json_encode($data);
}

//Ambil data untuk label face recognition
$folder_arr = $db->tampil_folder_array();
if (isset($_GET['read'])) {
    if ($folder_arr->num_rows > 0) {
        $data = [];

        while ($row = mysqli_fetch_object($folder_arr)) {
            $row1 = $row->nomor_id;
            $data[] = $row1;
            //echo $row1;
        }
        $data = implode(' ', $data);
        echo $data;
    }
}

// Update User Ajax Request
if (isset($_POST['update'])) {
    $size_sum = array_sum($_FILES['filesEdit']['size']);
    //Kalau image > 0 /Image Ada
    if ($size_sum > 0) {
        //kosongkan dulu
        $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType =
            '';
        $folder = $_POST['nomor_idEdit'];
        $id = $_POST['id_orang'];
        $ambil_no_id_lama = $db->ambil_nomor_id($id);
        $ambil_id_orang = $db->ambil_id_orang($id);
        $nomor_id_foto = $folder_baru = $_POST['nomor_idEdit'];
        $ambil_folder_lama = $db->ambil_folder($id);
        $folder_lama = $ambil_folder_lama['nomor_id'];

        if ($folder_baru !== $folder_lama) {
            //ubah nama direktori
            $folder_baru = $_POST['nomor_idEdit'];
            $id = $_POST['id_orang'];
            $ambil_folder_lama = $db->ambil_folder($id);
            $folder_lama = $ambil_folder_lama['nomor_id'];
            if ($folder_baru !== $folder_lama) {
                rename(
                    'assets/labeled_images/' . $folder_lama,
                    'assets/labeled_images/' . $folder_baru
                );
            }
        }
        //Hapus data loop di tbl foto
        $hapus_data_loop = $db->hapus_data_loop($id);
        if ($hapus_data_loop) {
            // File upload configuration
            $targetDir = 'assets/labeled_images/' . $folder_baru . '/';
            $allowTypes = ['jpg'];

            $fileNames = array_filter($_FILES['filesEdit']['name']);
            //Ambil data orang
            $dataOrang = [
                'id_orang' => $id,
                //'nomor_id' => $_POST['nomor_idEdit'],
                'nama' => $_POST['namaEdit'],

                'tmpt_lhrEdit' => $_POST['tmpt_lhrEdit'],
                'tgl_lhrEdit' => $_POST['tgl_lhrEdit'],
                'kelaminEdit' => $_POST['kelaminEdit'],
                'pekerjaanEdit' => $_POST['pekerjaanEdit'],
                'no_hpEdit' => $_POST['no_hpEdit'],
                'emailEdit' => $_POST['emailEdit'],
                'alamatEdit' => $_POST['alamatEdit'],
            ];
            //fungsi compress image
            /*
             * Custom function to compress image size and
             * upload to the server using PHP
             */
            function compressImage($source, $destination, $quality)
            {
                // Get image info
                $imgInfo = getimagesize($source);
                $mime = $imgInfo['mime'];
                // Create a new image from file
                switch ($mime) {
                    case 'image/jpg':
                        $image = imagecreatefromjpeg($source);
                        break;
                    default:
                        $image = imagecreatefromjpeg($source);
                }
                // Save image
                imagejpeg($image, $destination, $quality);
                // Return compressed image
                return $destination;
            }
            //batas function
            if (!empty($fileNames)) {
                $no = 1;
                foreach ($_FILES['filesEdit']['name'] as $key => $val) {
                    // File upload path Asli
                    $temp = explode('.', $_FILES['filesEdit']['name'][$key]);
                    $newfilename = $no++ . '.' . end($temp);
                    $fileName = $newfilename;

                    $targetFilePath = $targetDir . $fileName;
                    // Check whether file type is valid
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                    if (in_array($fileType, $allowTypes)) {
                        //menyiapkan pembatasan size
                        $ukuran_foto = $_FILES['filesEdit']['size'][$key];

                        $source = $_FILES['filesEdit']['tmp_name'][$key];
                        $compressedImage = compressImage(
                            $source,
                            $targetFilePath,
                            30
                        );

                        if ($compressedImage) {
                            $nomor_id_foto = $_POST['nomor_idEdit'];
                            // Image db insert sql
                            $insertValuesSQL .=
                                "(
                                '" .
                                $id .
                                "',
                                '" .
                                $nomor_id_foto .
                                "','" .
                                $fileName .
                                "', NOW()),";
                        } else {
                            echo $util->showMessage('danger', 'Gagal insert!');
                        }
                    } else {
                        echo $util->showMessage('danger', 'Gagal insert!');
                    }
                }
                $insertValuesSQL = trim($insertValuesSQL, ',');

                $db->update_orang($dataOrang);
                $db->tambah_foto($insertValuesSQL);
            }
        }

        //Kalau image < 0 /kalau foto tidak ada
    } else {
        //Ambil data orang
        $data = [
            'id_orang' => $_POST['id_orang'],
            'nama' => $_POST['namaEdit'],
            'nomor_id' => $_POST['nomor_idEdit'],

            'tmpt_lhrEdit' => $_POST['tmpt_lhrEdit'],
            'tgl_lhrEdit' => $_POST['tgl_lhrEdit'],
            'kelaminEdit' => $_POST['kelaminEdit'],
            'pekerjaanEdit' => $_POST['pekerjaanEdit'],
            'no_hpEdit' => $_POST['no_hpEdit'],
            'emailEdit' => $_POST['emailEdit'],
            'alamatEdit' => $_POST['alamatEdit'],
        ];
        $idx = $folder_baru = $_POST['nomor_idEdit'];
        $id = $_POST['id_orang'];

        //Update Database
        $db->update_data_orang($data);
        $db->update_tabel_foto($data);
    }
}

//Tambah Data
if (isset($_POST['add'])) {
    // Include the database configuration file
    $folder = $id = $_POST['nomor_id'];
    $ambil_no_id_lama = $db->ambil_nomor_id($id);
    //Cek nomor Id yg sama di database

    if ($ambil_no_id_lama->num_rows > 0) {
        echo 'ID dobel';
    } else {
        //ini input multiple image
        // Getting file name
        mkdir('assets/labeled_images/' . $folder, 0777, true);
        // File upload configuration
        $targetDir = 'assets/labeled_images/' . $folder . '/';
        $allowTypes = ['jpg'];
        $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType =
            '';
        $fileNames = array_filter($_FILES['files']['name']);
        //function
        /*
         * Custom function to compress image size and
         * upload to the server using PHP
         */

        //Ambil data orang

        $nomor_id = $_POST['nomor_id'];
        $nama = $_POST['nama1'];
        $tmpt_lhr = $_POST['tmpt_lhr1'];
        $tgl_lhr = $_POST['tgl_lhr1'];
        $kelamin = $_POST['kelamin1'];
        $pekerjaan = $_POST['pekerjaan1'];
        $no_hp = $_POST['no_hp1'];
        $email = $_POST['email1'];
        $alamat = $_POST['alamat1'];

        //fungsi compress image
        function compressImage($source, $destination, $quality)
        {
            // Get image info
            $imgInfo = getimagesize($source);
            $mime = $imgInfo['mime'];
            // Create a new image from file
            switch ($mime) {
                case 'image/jpg':
                    $image = imagecreatefromjpeg($source);
                    break;
                default:
                    $image = imagecreatefromjpeg($source);
            }
            // Save image
            imagejpeg($image, $destination, $quality);
            // Return compressed image
            return $destination;
        }
        //batas function
        if (!empty($fileNames)) {
            $no = 1;

            foreach ($_FILES['files']['name'] as $key => $val) {
                // File upload path Asli
                $temp = explode('.', $_FILES['files']['name'][$key]);
                $newfilename = $no++ . '.' . end($temp);
                $fileName = $newfilename;

                $targetFilePath = $targetDir . $fileName;
                // Check whether file type is valid
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                if (in_array($fileType, $allowTypes)) {
                    //menyiapkan pembatasan size
                    $ukuran_foto = $_FILES['files']['size'][$key];

                    $source = $_FILES['files']['tmp_name'][$key];
                    $compressedImage = compressImage(
                        $source,
                        $targetFilePath,
                        30
                    );

                    if ($compressedImage) {
                        // Image db insert sql
                        $nama_id = 'LAST_INSERT_ID()';
                        $nomor_id_foto = $_POST['nomor_id'];
                        $insertValuesSQL .=
                            "($nama_id,'" .
                            $nomor_id_foto .
                            "','" .
                            $fileName .
                            "', NOW()),";
                        if ($fileName == '1.jpg') {
                            $foto_single = $fileName;
                            $data = [
                                'foto_single' => $foto_single,
                                'nomor_id' => $nomor_id,
                                'nama' => $nama,
                                'tmpt_lhr' => $tmpt_lhr,
                                'tgl_lhr' => $tgl_lhr,
                                'kelamin' => $kelamin,
                                'pekerjaan' => $pekerjaan,
                                'no_hp' => $no_hp,
                                'email' => $email,
                                'alamat' => $alamat,
                            ];
                        }
                    } else {
                        $errorUpload .= $_FILES['files']['name'][$key] . ' | ';
                    }
                } else {
                    $errorUploadType .= $_FILES['files']['name'][$key] . ' | ';
                }
            }

            if (!empty($insertValuesSQL)) {
                $insertValuesSQL = trim($insertValuesSQL, ',');

                $db->tambah_orang($data);
                $db->tambah_foto($insertValuesSQL);
            }
        }
    }
}

// Edit Data Ajax Request
if (isset($_GET['edit'])) {
    $id = $_GET['id'];

    $data = $db->readOne($id);
    echo json_encode($data);
}

// Edit Data Foto Ajax Request
if (isset($_GET['image'])) {
    $id = $_GET['image'];

    $image = $db->readImage($id);
    echo json_encode($image);
}

// Hapus Data Ajax Request
if (isset($_GET['delete'])) {
    $id = $_GET['id'];
    $db->delete($id);
}

?>
