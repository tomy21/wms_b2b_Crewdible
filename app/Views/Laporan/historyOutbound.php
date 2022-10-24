<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>History Outbound</h1>
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
                        <th>Order Id</th>
                        <th>Nama Driver</th>
                        <th>Nama Penerima</th>
                        <th>Jam Slot</th>
                        <th>Selesai Packing</th>
                        <th>Selesai Handover</th>
                        <th>Keterangan</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $db = \Config\Database::connect();
                    $warehouse = $db->table('tbl_invoice')->getWhere(['stock_location' => user()->warehouse, 'status' => 6])->getResultArray();
                    $head = $db->table('tbl_invoice')->getWhere(['status' => 6])->getResultArray();
                    user()->warehouse == 'Headoffice' ? $data = $head : $data = $warehouse;
                    foreach ($data as $query) :
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $query['stock_location'] ?></td>
                        <td><?= $query['Order_id'] ?></td>
                        <td><?= $query['driver'] ?></td>
                        <td><?= $query['Drop_name'] ?></td>
                        <td><?= $query['created_at'] ?></td>
                        <td>
                            <?php
                                $db = \Config\Database::connect();
                                $warehouse = $db->table('tbl_packing')->getWhere(['order_id' => $query['Order_id']])->getRow();

                                echo $warehouse->updated_at;
                                ?>
                        </td>
                        <td><?php
                                $db = \Config\Database::connect();
                                $listHandover = $db->table('tbl_listhandover')->getWhere(['order_id' => $query['Order_id']])->getResult();
                                $id = [];
                                foreach ($listHandover as $m) :
                                    $id = $db->table('tbl_listhandover')->getWhere(['id' => $m->id])->getRow();
                                    echo $id->updated_at;
                                endforeach;

                                ?>
                        </td>
                        <td>
                            <?php $db = \Config\Database::connect();
                                $warehouse = $db->table('tbl_packing')->getWhere(['order_id' => $query['Order_id']])->getRow();
                                $date = $warehouse->updated_at;
                                if ($date > $query['created_at']) :
                                ?>
                            <span class="badge badge-danger"> Over SLA</span>
                            <?php else : ?>
                            <span class="badge badge-success"> Meet SLA</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center;">
                            <button class="btn btn-sm btn-info" type="button"
                                onclick="detail('<?= $query['id']; ?>')"><i class="fa fa-eye"></i></button>
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

function detail(id) {
    $.ajax({
        type: "post",
        url: "<?= site_url('/Handover/detailHandover') ?>",
        data: {
            id: id,
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