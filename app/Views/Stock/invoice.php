<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Order Status</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<link rel="stylesheet" href="<?= site_url() ?>/plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?= site_url() ?>/dist/css/adminlte.min.css">

<?php if (user()->warehouse == 'Headoffice') : ?>
    <div class="section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-danger">
                            <h3 class="card-title">Upload File Invoice</h3>
                        </div>
                        <div class="card-body">
                            <?= form_open_multipart('Invoice/upload') ?>
                            <?= session()->getFlashdata('error'); ?>
                            <?= session()->getFlashdata('success'); ?>
                            <div class="form-group row">
                                <div class="form-group col-md-6">
                                    <label for="fileimport">Upload Data</label>
                                    <input type="file" class="form-control" name="fileimport" accept=".xls,.xlsx " required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Slot</label>
                                    <select name="slot" id="slot" class="form-control" required>
                                        <option value="" selected> - Pilih Slot - </option>
                                        <option value="1">Slot 1 (Pagi)</option>
                                        <option value="2">Slot 2 (Siang)</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <button type="submit" class="btn btn-success form-control"> <i class="fa fa-upload"></i>
                                        Upload</button>
                                </div>
                                <?= form_close(); ?>
                                <?= form_open('Invoice/download') ?>
                                <div class="form-group col-sm-12">
                                    <button type="submit" class="btn btn-info form-control"> <i class="fa fa-download"></i>
                                        download tamplate</button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <?= form_open('Invoice/index') ?>
                    <div class="card">
                        <div class="card-header bg-danger">
                            <h3 class="card-title">
                                Pilih Warehouse
                            </h3>
                        </div>
                        <div class="card-body">
                            <select name="warehouse" id="warehouse" class="form-control <?php if (session('errors.warehouse')) : ?>is-invalid<?php endif ?>">
                                <option value="" selected> -- Pilih Warehouse -- </option>
                                <?php
                                $db = \Config\Database::connect();
                                $basket = $db->table('tbl_warehouse')->get()->getResult();
                                foreach ($basket as $row) :
                                ?>
                                    <option value="<?= $row->warehouse_name ?>"><?= $row->warehouse_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success"> Pilih </button>

                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="col-lg-12">

</div>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-danger">
            <h3 class="card-title">Tabel Transaksi</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <p>

                        <span class="badge badge-dark">Transaksi Baru</span>
                        <span class="badge badge-info">Assign</span>
                        <span class="badge badge-primary">Picking</span>
                        <span class="badge badge-warning">Packing</span>
                        <span class="badge badge-Fuchsia">Shipping</span>
                        <span class="badge badge-success">Done</span>
                        <span class="badge badge-danger">Return</span>

                    </p>
                    <table id="example1" class="table table-striped" style="width: 100%;">
                        <thead>
                            <th>No</th>
                            <th>Slot Time</th>
                            <th>Warehouse</th>
                            <th><?php if (user()->warehouse == 'Headoffice') : ?> Order ID <?php else : ?> Jumlah
                                    Invoice <?php endif; ?></th>
                            <th>Nama Penerima</th>
                            <th>No Tlp</th>
                            <th>Kota</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="viewmodal" style="display: none;"></div>
    </div>
</div>
<!-- jQuery -->
<script src="<? site_url() ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<? site_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<? site_url() ?>/dist/js/adminlte.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#example1').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [],
            "info": true,
            "ajax": {
                "url": "<?php echo site_url('Invoice/dataAjax') ?>",
                "type": "POST",
            },
            dom: 'lBftip', // Add the Copy, Print and export to CSV, Excel and PDF buttons
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }],
        });
    });


    // $('#warehouse').change(function(e) {
    //     let warehouse = $('#warehouse').val();

    //     if (warehouse != '') {
    //         $.ajax({
    //             type: "post",
    //             url: "<?= site_url('/Invoice/index') ?>",
    //             data: {
    //                 warehouse: warehouse
    //             },
    //             dataType: "JSON",
    //             success: function(response) {

    //             }
    //         });
    //     }

    // });



    function detail(order) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/Invoice/detail') ?>",
            data: {
                order: order,
            },
            dataType: "json",
            success: function(response) {

                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalitem').modal('show');

                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }

    function detailwarehouse(penerima) {
        $.ajax({
            type: "post",
            url: "<?= site_url('/Invoice/detailWarehouse') ?>",
            data: {
                penerima: penerima,
            },
            dataType: "json",
            success: function(response) {

                if (response.data) {
                    $('.viewmodal').html(response.data).show();
                    $('#modalitem').modal('show');

                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }
</script>

<?= $this->endsection('isi'); ?>