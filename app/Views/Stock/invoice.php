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
                        <select name="warehouse" id="warehouse"
                            class="form-control <?php if (session('errors.warehouse')) : ?>is-invalid<?php endif ?>">
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
                            <tr>
                                <?php

                                if (user()->warehouse == 'Headoffice') {
                                    $db = \Config\Database::connect();
                                    $date = date('d-m-Y H:i:s');
                                    $hari = 1;
                                    $hariKemarin = date('Y-m-d', strtotime('-$hari day', strtotime($date)));
                                    $data2 =
                                        $db->table('tbl_order')->where(['created_at>=' => $hariKemarin])->orderBy('status', 'ASC')->get()->getResult();
                                } else {
                                    $db = \Config\Database::connect();
                                    $date = date('d-m-Y H:i:s');
                                    $hari = 1;
                                    $hariKemarin = date('Y-m-d', strtotime('-$hari day', strtotime($date)));
                                    $orderDone = 6;
                                    $data1 = $db->table('tbl_order')->where(['stock_location' => user()->warehouse, 'created_at>=' => $hariKemarin])->select('status,created_at,stock_location, Drop_name, Drop_contact, Drop_city, count(Order_id) as Order_id')->groupBy('Drop_name', 'created_at', 'ASC')->get()->getResult();
                                }
                                $data = user()->warehouse == 'Headoffice' ? $data2 : $data1;
                                $no = 1;
                                foreach ($data as $user) :
                                ?>
                                <td><?= $no++; ?></td>
                                <td><?= $user->created_at ?></td>
                                <td><?= $user->stock_location ?></td>
                                <td><?= $user->Order_id ?></td>
                                <td><?= $user->Drop_name ?></td>
                                <td><?= $user->Drop_contact ?></td>
                                <td><?= $user->Drop_city ?></td>
                                <td>
                                    <?php if ($user->status == "1") : ?>
                                    <span class="badge badge-dark">Transaksi Baru</span>
                                    <?php elseif ($user->status == "2") :  ?>
                                    <span class="badge badge-info">Assign</span>
                                    <?php elseif ($user->status == "3") :  ?>
                                    <span class="badge badge-primary">Picking</span>
                                    <?php elseif ($user->status == "4") :  ?>
                                    <span class="badge badge-warning">Packing</span>
                                    <?php elseif ($user->status == "5") :  ?>
                                    <span class="badge badge-Fuchsia">Shipping</span>
                                    <?php elseif ($user->status == "6") :  ?>
                                    <span class="badge badge-success">Done</span>
                                    <?php elseif ($user->status == "7") :  ?>
                                    <span class="badge badge-danger">Return</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (user()->warehouse == 'Headoffice') : ?>
                                    <button type="button" class="btn btn-sm btn-info"
                                        onclick="detail('<?= $user->Order_id; ?>')"><i class="fa fa-eye"></i></button>
                                    <?php else : ?>
                                    <button type="button" class="btn btn-sm btn-info"
                                        onclick="detailwarehouse('<?= $user->Drop_name; ?>')"><i
                                            class="fa fa-eye"></i></button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
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
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

});

$('#warehouse').change(function(e) {
    let warehouse = $('#warehouse').val();

    if (warehouse != '') {
        $.ajax({
            type: "post",
            url: "<?= site_url('/Invoice/index') ?>",
            data: {
                warehouse: warehouse
            },
            dataType: "JSON",
            success: function(response) {

            }
        });
    }

});



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

function detail(penerima) {
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