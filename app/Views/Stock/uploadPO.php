<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Upload PO </h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-danger">
            <h3 class="card-title">Upload File PO</h3>
        </div>
        <div class="card-body">
            <?= form_open_multipart('UploadPo/Upload') ?>
            <?= session()->getFlashdata('error'); ?>
            <?= session()->getFlashdata('success'); ?>
            <div class="form-group row">
                <div class="form-group col-md-2">
                    <label for="fileimport">No PO</label>
                    <input type="text" class="form-control" name="noPo" id="noPo" value="<?= $nopo ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="fileimport">Warehouse</label>
                    <select name="warehouse" id="warehouse"
                        class="form-control <?php if (session('errors.warehouse')) : ?>is-invalid<?php endif ?>"
                        required>
                        <option value="" selected disabled> -- Pilih Warehouse -- </option>
                        <?php
                        $db = \Config\Database::connect();
                        $basket = $db->table('tbl_warehouse')->get()->getResult();
                        foreach ($basket as $row) :
                        ?>
                        <option value="<?= $row->warehouse_name ?>"><?= $row->warehouse_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">
                <div class="form-group col-md-6">
                    <label for="fileimport">Upload Data</label>
                    <input type="file" class="form-control" name="fileimport" accept=".xls,.xlsx " required>
                </div>
                <div class="form-group col-md-6">
                    <label for="fileimport">Estimasi</label>
                    <input type="date" class="form-control" name="estimate" id="estimate" value="" required>
                </div>
                <div class="form-group col-sm-2">
                    <button type="submit" class="btn btn-success form-control"> <i class="fa fa-upload"></i>
                        Upload</button>

                </div>
                <?= form_close(); ?>
                <?= form_open('UploadPo/download') ?>
                <div class="form-group col-sm-12">
                    <button type="submit" class="btn btn-info form-control"> <i class="fa fa-download"></i>
                        download tamplate</button>
                </div>
                <?= form_close(); ?>
            </div>

        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-danger">
            <h3 class="card-title">Tabel List PO</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <table id="example1" class="table table-striped" style="width: 100%;">
                        <thead>
                            <th>No</th>
                            <th>Warehouse</th>
                            <th>No_Po</th>
                            <th>Item ID</th>
                            <th>Item Detail</th>
                            <th>Quantity</th>
                            <!-- <th>Estimasi kedatangan</th> -->
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $no = 1;
                                foreach ($data->getResultArray() as $user) :
                                ?>
                                <td><?= $no++; ?></td>
                                <td><?= $user['warehouse'] ?></td>
                                <td><?= $user['nopo']; ?></td>
                                <td><?= $user['Item_id']; ?></td>
                                <td><?= $user['Item_detail']; ?></td>
                                <td><?= $user['quantity']; ?></td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="formCekResi" style="display: none;"></div>
</div>


<script>
$(function() {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
        "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

});
</script>

<?= $this->endsection('isi'); ?>