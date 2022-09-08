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
            <button class="btn btn-sm btn-info" onclick="location.href=('/ReturnItem/dataReturn')"><i
                    class="fa fa-plus-circle"></i>&nbsp; Terima Return</button>&nbsp;

        </div>
        <div class="card-body">
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
                    <tr>
                        <th>No</th>
                        <th>Order id</th>
                        <th>Item Id</th>
                        <th>Item Detail</th>
                        <th>Quantity</th>
                        <th>Received</th>
                        <th>Status</th>
                        <th>#</th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($data as $query) :
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $query['Order_id'] ?></td>
                        <td><?= $query['Item_id'] ?></td>
                        <td><?= $query['Item_detail'] ?></td>
                        <td><?= $query['qty'] ?></td>
                        <td><?= $query['Receive'] ?></td>
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
                            <button type="button" class="btn btn-sm btn-info"><i class="fa fa-inbox"
                                    onclick="detail(<?= $query['Item_id'] ?>)"></i></button>
                            <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-inbox"
                                    onclick="detailRtn(<?= $query['Item_id'] ?>)"></i></button>
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
let crsfToken = '<?= csrf_token() ?>';
let crsfHash = '<?= csrf_hash() ?>';

function detail(idItem) {
    $.ajax({
        type: "post",
        url: "/ReturnItem/detail",
        data: {
            [crsfToken]: crsfHash,
            idItem: idItem,
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

function detailRtn(idItem) {
    $.ajax({
        type: "post",
        url: "/ReturnItem/detailRtn",
        data: {
            [crsfToken]: crsfHash,
            idItem: idItem,
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