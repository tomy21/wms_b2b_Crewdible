<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>History Inbound</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>


<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Warehouse</th>
                        <th>No PO</th>
                        <th>Nama Driver</th>
                        <th>No Pelat Kendaraan</th>
                        <th>Kedatangan Driver</th>
                        <th>Tanggal Diterima</th>
                        <th>Tanggal Input to stock</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $db = \Config\Database::connect();
                    $warehouse = $db->table('tbl_po')->getWhere(['warehouse' => user()->warehouse, 'status' => 2])->getResultArray();
                    $head = $db->table('tbl_po')->getWhere(['status' => 2])->getResultArray();
                    user()->warehouse == 'Headoffice' ? $data = $head : $data = $warehouse;
                    foreach ($data as $query) :
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $query['warehouse'] ?></td>
                        <td><?= $query['no_Po'] ?></td>
                        <td><?= $query['driver'] ?></td>
                        <td><?= $query['noplat'] ?></td>
                        <td><?= $query['waktu_datang'] ?></td>
                        <td><?= $query['updated_at'] ?></td>
                        <td><?= $query['updated_at'] ?></td>
                        <td style="text-align:center;">
                            <button class="btn btn-sm btn-info" type="button"
                                onclick="detail('<?= $query['no_Po']; ?>')"><i class="fa fa-eye"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>

<script>
$(function() {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": true,
        "autoWidth": true,
        "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

});

function detail(po) {
    $.ajax({
        type: "post",
        url: "<?= site_url('/Inbound/detailInbound') ?>",
        data: {
            po: po,
        },
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('.viewmodal').html(response.data).show();
                $('#modalDetail').modal('show');

            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}
</script>

<?= $this->endsection('isi'); ?>