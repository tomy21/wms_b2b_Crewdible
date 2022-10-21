<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Stock</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-cyan">
            <h3 class="card-title">Tabel Stock</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <table id="example1" class="table table-striped" style="width: 100%;">
                        <thead>
                            <th>No</th>
                            <th>Warehouse</th>
                            <th>Item ID</th>
                            <th>Item Detail</th>
                            <th>Quantity All</th>
                            <th>Good Items</th>
                            <th>Bad Items</th>
                            <th>Reserved</th>
                            <th>Tgl Inbound</th>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $no = 1;
                                $db = \Config\Database::connect();

                                if (user()->warehouse == 'Headoffice') {
                                    $office = $db->table('tbl_stock')->get()->getResultArray();
                                } else {
                                    $wh = $db->table('tbl_stock')->where(['warehouse' => user()->warehouse])->get()->getResultArray();
                                }
                                user()->warehouse == 'Headoffice' ? $data = $office : $data = $wh;
                                foreach ($data as $user) :
                                ?>
                                <td><?= $no++; ?></td>
                                <td><?= $user['warehouse']; ?></td>
                                <td><?= $user['sku']; ?></td>
                                <td><?= $user['Item_detail']; ?></td>
                                <td align="center">
                                    <?= intval($user['quantity_good']) + intval($user['quantity_reject']); ?>
                                </td>
                                <td align="center"><?= $user['quantity_good']; ?></td>
                                <td align="center"><?= $user['quantity_reject']; ?></td>
                                <td align="center"><?= $user['qty_received']; ?></td>
                                <td><?= $user['created_at']; ?></td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="formCekResi" style="display: none;"></div>
</div>
<script>
function hapusitem(sku) {
    Swal.fire({
        title: 'Hapus Item',
        text: "Yakin hapus SKU ini ? ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Hapus Dong!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= site_url() ?>/Stock/hapusSku",
                data: {
                    sku: sku
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Stock Sudah di delete',
                            text: response.sukses,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    })
}

$(document).ready(function() {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": true,
        "buttons": ["excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#warehouse').change(function() {
        // let a = $(this).val();
        // console.log(a);
    });

    function warehouse() {
        var warehuse = $('#warehouse').val();
        $.ajax({
            type: "post",
            url: "<?= site_url('Stock/filter') ?>",
            data: {
                warehouse: warehouse,
            },
            dataType: "dataType",
            success: function(response) {
                $('#warehouse tbody').html('')
            }
        });
    }
});
</script>

<?= $this->endsection('isi'); ?>