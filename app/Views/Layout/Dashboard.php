<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Dashboard</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>
                            <?php
                            $db = \Config\Database::connect();
                            $data = $db->table('tbl_order')->where(['stock_location' => user()->warehouse, 'created_at' => date('Y-m-d')])->countAllResults();

                            ?>
                            <?= user()->warehouse == 'Headoffice' ? "$total" : "$data"; ?>
                        </h3>
                        <p>Total Transaksi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>
                            <?php
                            $db = \Config\Database::connect();
                            $data = $db->table('tbl_order')->where(['stock_location' => user()->warehouse, 'status' => 1])->countAllResults();

                            ?>
                            <?= user()->warehouse == 'Headoffice' ? "$new" : "$data"; ?>
                        </h3>
                        <p>Transaksi Baru</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cube"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>
                            <?php
                            $db = \Config\Database::connect();
                            $data = $db->table('tbl_order')->where(['stock_location' => user()->warehouse, 'status' => 3])->countAllResults();

                            ?>
                            <?= user()->warehouse == 'Headoffice' ? "$picking" : "$data"; ?>
                        </h3>
                        <p>Picking</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cube"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>
                            <?php
                            $db = \Config\Database::connect();
                            $data = $db->table('tbl_order')->where(['stock_location' => user()->warehouse, 'status' => 4])->countAllResults();

                            ?>
                            <?= user()->warehouse == 'Headoffice' ? "$packing" : "$data"; ?>
                        </h3>
                        <p>Packing</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cube"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>
                            <?php
                            $db = \Config\Database::connect();
                            $data = $db->table('tbl_order')->where(['stock_location' => user()->warehouse, 'status' => 5])->countAllResults();

                            ?>
                            <?= user()->warehouse == 'Headoffice' ? "$shipping" : "$data"; ?>
                        </h3>
                        <p>Shipping</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cube"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>
                            <?php
                            $db = \Config\Database::connect();
                            $data = $db->table('tbl_order')->where(['stock_location' => user()->warehouse, 'status' => 6])->countAllResults();

                            ?>
                            <?= user()->warehouse == 'Headoffice' ? "$done" : "$data"; ?>
                        </h3>
                        <p>Done</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cube"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>
                            <?php
                            $db = \Config\Database::connect();
                            $data = $db->table('tbl_order')->where(['stock_location' => user()->warehouse, 'status' => 7])->countAllResults();

                            ?>
                            <?= user()->warehouse == 'Headoffice' ? "$done" : "$data"; ?>
                        </h3>
                        <p>Return</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>
                            <?php
                            $db = \Config\Database::connect();
                            $data = $db->table('tbl_stock')->where(['warehouse' => user()->warehouse])->countAllResults();

                            ?>
                            <?= user()->warehouse == 'Headoffice' ? "$done" : "$data"; ?>
                        </h3>
                        <p>Count Items</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Monthly Recap Report</h5>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-wrench"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                            <a href="#" class="dropdown-item">Action</a>
                            <a href="#" class="dropdown-item">Another action</a>
                            <a href="#" class="dropdown-item">Something else here</a>
                            <a class="dropdown-divider"></a>
                            <a href="#" class="dropdown-item">Separated link</a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <p class="text-center">
                            <strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
                        </p>


                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                        </div>
                        <span class="badge" style="background-color:rgba(60,141,188,0.9);">Total Inbound</span>
                        <span class="badge" style="background-color:rgba(210, 214, 222, 1);">Total Outbound</span>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <p class="text-center">
                            <strong>Goal Completion</strong>
                        </p>

                        <div class="progress-group">
                            Add Products to Cart
                            <span class="float-right"><b>160</b>/200</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: 80%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                            Complete Purchase
                            <span class="float-right"><b>310</b>/400</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-danger" style="width: 75%"></div>
                            </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                            <span class="progress-text">Visit Premium Page</span>
                            <span class="float-right"><b>480</b>/800</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width: 60%"></div>
                            </div>
                        </div>

                        <!-- /.progress-group -->
                        <div class="progress-group">
                            Send Inquiries
                            <span class="float-right"><b>250</b>/500</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- ./card-body -->
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                            <h5 class="description-header">30.000</h5>
                            <span class="description-text">TOTAL ORDER</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                            <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i>
                                0%</span>
                            <h5 class="description-header">5</h5>
                            <span class="description-text">TOTAL WAREHOUSE</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block border-right">
                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i>
                                <?= round((intval(30000) / intval(70)) / intval(100), 2) ?>%</span>
                            <h5 class="description-header">70</h5>
                            <span class="description-text">TOTAL COMPLAIN</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 col-6">
                        <div class="description-block">
                            <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i>
                                <?= round((intval(50000) / intval(30000)) / intval(100), 2) ?> %</span>
                            <h5 class="description-header">50.000</h5>
                            <span class="description-text">GOAL</span>
                        </div>
                        <!-- /.description-block -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>


<!-- TABLE: LATEST ORDERS -->
<div class="card">
    <div class="card-header border-transparent">
        <h3 class="card-title">Summary Outbound</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Warehouse</th>
                        <th>Count Order</th>
                        <th>Count Item</th>
                        <th>Total Quantity</th>
                        <th>Meet SLA</th>
                        <th>Over SLA</th>
                        <th>% MeetSLA (order/meet)</th>
                        <th>% OverSLA (order/over)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($warehouse as $x) : ?>
                    <tr>
                        <td><?= $x->stock_location; ?></td>
                        <td>
                            <?php
                                $db = \Config\Database::connect();
                                $jumlah = $db->table('tbl_order')->where('stock_location', $x->stock_location)->countAllResults();

                                echo $jumlah;
                                ?>
                        </td>
                        <td><?= $x->item; ?></td>
                        <td><?= $x->qty; ?></td>
                        <td>
                            <?php
                                $db = \Config\Database::connect();
                                $jumlah = $db->table('tbl_order')->where('stock_location', $x->stock_location)->get()->getResult();

                                foreach ($jumlah as $value) {
                                }
                                ?>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
                <?php endforeach; ?>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.card-body -->

    <!-- /.card-footer -->
</div>
<div class="card">
    <div class="card-header border-transparent">
        <h3 class="card-title">Summary Dock to Stock</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>Warehouse</th>
                        <th>Count Order</th>
                        <th>Count Item</th>
                        <th>Total Quantity</th>
                        <th>Meet SLA</th>
                        <th>Over SLA</th>
                        <th>% MeetSLA (order/meet)</th>
                        <th>% OverSLA (order/over)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($warehouse as $x) : ?>
                    <tr>
                        <td><?= $x->stock_location; ?></td>
                        <td>
                            <?php
                                $db = \Config\Database::connect();
                                $jumlah = $db->table('tbl_order')->where('stock_location', $x->stock_location)->countAllResults();

                                echo $jumlah;
                                ?>
                        </td>
                        <td><?= $x->item; ?></td>
                        <td><?= $x->qty; ?></td>
                        <td>
                            <?php
                                $db = \Config\Database::connect();
                                $jumlah = $db->table('tbl_order')->where('stock_location', $x->stock_location)->get()->getResult();

                                foreach ($jumlah as $value) {
                                }
                                ?>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
                <?php endforeach; ?>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.card-body -->

    <!-- /.card-footer -->
</div>
<!-- /.card -->
</div>
<!-- /.col -->
<!-- <div class="viewTampilGrafik"></div> -->
<!-- /.content -->
</div>

<script>
// let crsfToken = '<?= csrf_token() ?>';
// let crsfHash = '<?= csrf_hash() ?>';

// function tampilGrafik() {
//     $.ajax({
//         type: "post",
//         url: "/Report/tampilGrafikBarangMasuk",
//         data: {
//             [crsfToken]: crsfHash,
//             bulan: '2022-06'
//         },
//         dataType: "json",
//         beforeSend: function() {
//             $('.viewTampilGrafik').html('<i class="fa fa-spin fa-spinner></i>')
//         },
//         success: function(response) {
//             if (response.data) {
//                 $('.viewTampilGrafik').html(response.data);
//             }
//         },
//         error: function(xhr, ajaxOptions, thrownError) {
//             alert(xhr.status + '\n' + thrownError);
//         }
//     });
// }
// $(document).ready(function() {
//     tampilGrafik();
// });
</script>
<script src="<?= site_url() ?>dist/js/adminlte.js"></script>
<script src="<?= site_url() ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
<script src="<?= site_url() ?>dist/js/pages/dashboard2.js"></script>
<?= $this->endsection('isi'); ?>