<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Dashboard</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>
<style>
    #container {
        height: 100%;
    }

    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 100%;
        max-width: 100%;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 100%;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
</style>
<?= form_open(site_url('Main/dashboardData')) ?>
<div class="row m-auto">
    <div class="col-3">
        <div class="form-group row">
            <label for="" class="col-sm-4 col-form-label">Start Date</label>
            <div class="col-sm-8">
                <input type="date" name="start" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group row">
            <label for="" class="col-sm-4 col-form-label">End Date</label>
            <div class="col-sm-8">
                <input type="date" name="end" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-3">
        <button type="submit" name="btnFilter" class="btn btn-info"> Filter</button>
    </div>
</div>
<?= form_close(); ?>
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
                <h5 class="card-title">Report by Warehouse</h5>

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
            <div class="card-body">
                <div class="row">
                    <figure class="highcharts-figure">
                        <div id="container"></div>

                    </figure>
                </div>
                <!-- /.row -->
            </div>
            <!-- ./card-body -->

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
    <div class="card-body">
        <div class="table-responsive">

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
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
                    <?php $no = 1;
                    foreach ($warehouse as $x) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
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
                                $meetSLA = $db->table('tbl_packing')->where(['warehouse' => $x->stock_location, 'updated_at>=' => $x->created_at])->countAllResults();

                                echo $meetSLA;
                                ?>
                            </td>
                            <td>
                                <?php
                                $db = \Config\Database::connect();
                                $overSLA = $db->table('tbl_packing')->where(['warehouse' => $x->stock_location, 'updated_at<=' => $x->created_at])->countAllResults();

                                echo $overSLA;
                                ?>
                            </td>
                            <td>
                                <?= round((intval($meetSLA) / intval($jumlah) * 100), 2) ?> %
                            </td>
                            <td>
                                <?= round((intval($overSLA) / intval($jumlah) * 100), 2) ?> %
                            </td>
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
<?php
$namaWarehouse  = [];
$jumlahOrder    = [];
foreach ($dataOrder as $p) {
    $namaWarehouse[] = $p->stock_location;
    $db = \Config\Database::connect();
    $jumlahOrder[] = $db->table('tbl_order')->where('stock_location',$p->stock_location)->countAllResults();
}
print_r(json_encode($jumlahOrder));
?>
<script>

</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    Highcharts.chart('container', {
        chart: {
            type: 'area'
        },
        title: {
            text: 'Jumlah Order By Warehouse'
        },
        yAxis: {
            title: {
                text: 'Billions',
            },
            lables: {
                formatter: function() {
                    return this.value;
                }
            }
        },
        xAxis: {
            categories: <?= json_encode($namaWarehouse) ?>,
            tickmarkPlacement: 'on',
            title: {
                enabled: false,
            }
        },
        plotOptions: {

            area: {
                stacking: 'normal',
                lineColor: '#666666',
                lineWidth: 1,
                marker: {
                    lineWidth: 1,
                    lineColor: '#666666'
                }
            }
        },
        series: [{
            name: 'Jumlah Order',
            data: <?= json_encode($jumlahOrder) ?>
        }]
    });
</script>
<?= $this->endsection('isi'); ?>