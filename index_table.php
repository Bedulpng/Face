<?php
include_once 'master_db.php';
$ambilDataTable = new Database();
$DataTable = $ambilDataTable->data_semua();
?>
<div class="col-lg-12">
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" id="table_id">
            <thead class="table-success ">
                <tr>
                    <th class=" text-center">No.</th>
                    <th class=" text-center">Foto</th>
                    <th class=" text-center">No ID</th>
                    <th class=" text-center">Nama</th>
                    <th class=" text-center">Pekerjaan</th>
                    <th class=" text-center"></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($DataTable->num_rows > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_object($DataTable)) { ?>
                <tr>
                    <td class=" text-center"><?php echo $no++; ?>.</td>
                    <td class=" text-center"><img src="assets/labeled_images/<?php echo $row->nomor_id; ?>
                /<?php echo $row->image_single; ?>" width="100px" height="100px"></td>
                    <td><?php echo $row->nomor_id; ?></td>
                    <td><?php echo $row->nama; ?></td>
                    <td><?php echo $row->pekerjaan; ?></td>
                    <td class=" text-center"><a href="#" type="button" id="<?php echo $row->id_orang; ?>"
                            class="btn btn-success  py-0 editLink" data-bs-toggle="modal"
                            data-bs-target="#editModalData">Edit</a> <a href="#" id="<?php echo $row->id_orang; ?>"
                            class="btn btn-danger  py-0 deleteLink">Delete</a></td>
                </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
</div>
