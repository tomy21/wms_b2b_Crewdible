<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Master Warehouse</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="form-group col-md-2">
                <div class="input-group">
                    <button class="btn btn-info" title="tambah" id="tambahBasket"> Tambah Warehouse
                    </button>
                </div>
            </div>
            <table id="viewStatus" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Warehouse Id</th>
                        <th>Warehouse</th>
                        <th>#</th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($data as $row) :
                    ?>

                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['id_warehouse'] ?></td>
                        <td><?= $row['warehouse_name'] ?></td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="edit('<?= $row['id_warehouse']; ?>')"> <i
                                    class="fa fa-pen"></i></button>
                            <button class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modalTambah" style="display: none;"></div>
<div class="updateWarehouse" style="display: none;"></div>

<script>
function edit(warehouse) {
    $.ajax({
        type: "post",
        url: "<?= site_url() ?>MasterWarehouse/updateData",
        data: {
            code: warehouse,
        },
        dataType: "json",
        success: function(response) {

            if (response.data) {
                $('.updateWarehouse').html(response.data).show();
                $('#updateWarehouse').modal('show');

            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}
$('#tambahBasket').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: "<?= site_url() ?>/MasterWarehouse/modalTambah",
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('.modalTambah').html(response.data).show();
                $('#modalTambah').modal('show');
            }
        }
    });
});
</script>

<?= $this->endsection('isi'); ?>