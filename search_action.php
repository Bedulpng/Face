<?php
include_once 'master_db.php';
$folder = new Database();
$folder_arr = $folder->tampil_folder_array();

if (isset($_GET['read'])) {
    if ($folder_arr->num_rows > 0) {
        $data = [];

        while ($row = mysqli_fetch_object($folder_arr)) {
            $row1 = $row->nama;
            //$data[] = "'" . $row1 . "'";
            $data[] = $row1;
            //echo $row1;
        }
        //$data = implode(',', $data);
        $data = implode(' ', $data);
        echo $data;
    }
}
?>
