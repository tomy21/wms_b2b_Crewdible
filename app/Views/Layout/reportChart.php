<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
Report Data
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>
Cetak Laporan 
<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="card-deck">
<div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
    <div class="card-header">Report Inbound</div>
    <div class="card-body bg-white">
        <?= form_open('report/cetakReportInbound', ['target' => '_blank']) ?>
        <div class="form-group">
            <label for="">Tanggal Awal</label>
            <input type="date" name="tglAwal" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="">Tanggal Akhir</label>
            <input type="date" name="tglAkhir" class="form-control" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-success">
                <i class="fa fa-print"> Cetak Laporan</i>
            </button>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
    <div class="card-header">Report Outbound</div>
    <div class="card-body bg-white">
        <?= form_open('report/cetakReportOutbound', ['target' => '_blank']) ?>
        <div class="form-group">
            <label for="">Tanggal Awal</label>
            <input type="date" name="tglAwalOut" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="">Tanggal Akhir</label>
            <input type="date" name="tglAkhirOut" class="form-control" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-success">
                <i class="fa fa-print"> Cetak Laporan</i>
            </button>
        </div>
        <?= form_close(); ?>
    </div>
</div>
</div>



<?= $this->endsection('isi'); ?>