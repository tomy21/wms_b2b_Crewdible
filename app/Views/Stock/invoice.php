<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Order Status</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-danger">
            <h3 class="card-title">Upload File Invoice</h3>
        </div>
        <div class="card-body">
            <p>
                <?= form_open_multipart('Invoice/upload') ?>
                <?= session()->getFlashdata('error'); ?>
                <?= session()->getFlashdata('success'); ?>
            <div class="form-group row">

                <div class="form-group col-md-4">
                    <label for="fileimport">Upload Data</label>
                    <input type="file" class="form-control" name="fileimport" accept=".xls,.xlsx ">
                </div>
                <div class="form-group col-md-4">
                    <label for="fileimport">Created Date</label>
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
            <h3 class="card-title">Tabel Transaksi</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <p>

                        <span class="badge badge-dark">Transaksi Baru</span>
                        <span class="badge badge-info">Assign</span>
                        <span class="badge badge-primary">Picking</span>
                        <span class="badge badge-secondary">Sorting</span>
                        <span class="badge badge-warning">Packing</span>
                        <span class="badge badge-Fuchsia">Shipping</span>
                        <span class="badge badge-success">Done</span>
                        <span class="badge badge-danger">Return</span>

                    </p>
                    <table id="viewStatus" class="table table-striped" style="width: 100%;">
                        <thead>
                            <th>No</th>
                            <th>Warehouse</th>
                            <th>Order ID</th>
                            <th>Nama Penerima</th>
                            <th>No Tlp</th>
                            <th>Kota</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $no = 1;
                                foreach ($data as $user) :
                                ?>
                                <td><?= $no++; ?></td>
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
                                    <span class="badge badge-secondary">Sorting</span>
                                    <?php elseif ($user->status == "5") :  ?>
                                    <span class="badge badge-warning">Packing</span>
                                    <?php elseif ($user->status == "6") :  ?>
                                    <span class="badge badge-Fuchsia">Shipping</span>
                                    <?php elseif ($user->status == "7") :  ?>
                                    <span class="badge badge-success">Done</span>
                                    <?php elseif ($user->status == "8") :  ?>
                                    <span class="badge badge-danger">Return</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info"
                                        onclick="detail('<?= $user->Order_id; ?>')"><i class="fa fa-inbox"></i></button>
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
<script>
$(document).ready(function() {
    $('#viewStatus').DataTable();

});

function detail(order) {
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';
    $.ajax({
        type: "post",
        url: "<?= site_url('/Invoice/detail') ?>",
        data: {
            [crsfToken]: crsfHash,
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
</script>

<?= $this->endsection('isi'); ?>