<?= $this->extend('layout/layout'); ?>
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
            <p>
                <?= form_open_multipart('UploadPo/Upload') ?>
                <?= session()->getFlashdata('error'); ?>
                <?= session()->getFlashdata('success'); ?>
            <div class="form-group col-md-2">
                <label for="fileimport">No PO</label>
                <input type="text" class="form-control" name="noPo" id="noPo" value="<?= $nopo ?>" readonly>
            </div>
            <div class="form-group row">
                <div class="form-group col-md-4">
                    <label for="fileimport">Upload Data</label>
                    <input type="file" class="form-control" name="fileimport" accept=".xls,.xlsx ">
                </div>
                <div class="form-group col-md-4">
                    <label for="fileimport">Upload Date</label>
                    <input type="datetime" class="form-control" name="tglupload" id="tglManifest"
                        value="<?= date('Y-m-d H:i:s') ?>" readonly>
                </div>
                <label for="fileimport" class="col-sm-4 col-form-label"></label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </div>
            <?= form_close(); ?>
            </p>
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
                    <table id="viewStatus" class="table table-striped" style="width: 100%;">
                        <thead>
                            <th>No</th>
                            <th>No_Po</th>
                            <th>Item ID</th>
                            <th>Item Detail</th>
                            <th>Quantity</th>
                            <th>Tgl Upload</th>
                        </thead>
                        <tbody>
                            <tr>
                            <tr>
                                <?php
                                $no = 1;
                                foreach ($data->getResultArray() as $user) :
                                ?>
                                <td><?= $no++; ?></td>
                                <td><?= $user['nopo']; ?></td>
                                <td><?= $user['Item_id']; ?></td>
                                <td><?= $user['Item_detail']; ?></td>
                                <td><?= $user['quantity']; ?></td>
                                <td><?= $user['created_at']; ?></td>

                            </tr>

                            </tr>
                            <?php endforeach; ?>

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="formCekResi" style="display: none;"></div>
</div>
<script>
$(document).ready(function() {
    $('#viewStatus').DataTable();
});
</script>

<?= $this->endsection('isi'); ?>