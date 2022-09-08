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
                        <h3><?= $total ?></h3>
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
                        <h3><?= $new ?></h3>
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
                        <h3><?= $picking ?></h3>
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
                        <h3><?= $packing ?></h3>
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
                        <h3><?= $done ?></h3>
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
                        <h3><?= $return ?></h3>
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
                        <h3><?= $stockData ?></h3>
                        <p>Count Items</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-pink">
                    <div class="inner">
                        <h3><?= $qtyStock ?></h3>
                        <p>Amount Items</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
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
<?= $this->endsection('isi'); ?>
