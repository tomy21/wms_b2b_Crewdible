<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Report Proses</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        Export Report Outbound
                    </div>
                    <div class="card-body">
                        <?= form_open(site_url('Laporan/cetakReportOutbound')) ?>
                        <div class="form-group">
                            <label>Tanggal Mulai :</label>
                            <div class="input-group date" id="awal" data-target-input="nearest">
                                <input type="date" class="form-control" name="valAwalOut" />

                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Akhir:</label>
                            <div class="input-group date" id="akhir" data-target-input="nearest">
                                <input type="date" class="form-control" name="valAkhirOut" />

                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info" id="btnOutbound"><i class="fa fa-download"></i> download data</button>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        Export Report Inbound
                    </div>
                    <div class="card-body">
                        <?= form_open(site_url('Laporan/cetakReportInbound')) ?>
                        <div class="form-group">
                            <label>Tanggal Mulai :</label>
                            <div class="input-group date" id="awalIn" data-target-input="nearest">
                                <input type="date" class="form-control" name="valAwalIn" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Akhir:</label>
                            <div class="input-group date" id="akhirIn" data-target-input="nearest">
                                <input type="date" class="form-control" name="valAkhirIn" />
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info" id="btnOutbound"><i class="fa fa-download"></i> download data</button>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#tabel1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#report1 .col-md-6:eq(0)');
    });


    
</script>
<?= $this->endsection('isi'); ?>