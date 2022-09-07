<?= $this->extend('layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Laporan Inbound</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>


<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="card">
    <div class="card-header bg-white">
        <button class="btn btn-sm btn-warning" onclick="window.location=('/laporan/index')"> Kembali</button>
    </div>
    <div class="card-body">
        <div class="card border-primary mb-3" style="max-width: 18rem;">
            <div class="card-header bg-cyan">Header</div>
            <div class="card-body">
                <?= form_open('laporan/cetak-inbound-periode', ['target' => '_blank']) ?>
                <div class="form-group">
                    <label for="">Tanggal Awal</label>
                    <input type="date" name="tglawal" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="">Tanggal Akhir</label>
                    <input type="date" name="tglakhir" class="form-control" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="cetak" class="btn btn-block btn-outline-success">
                        <i class="fa fa-print"></i> Cetak Laporan
                    </button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endsection('isi'); ?>