<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1> Inbound </h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>
<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-danger">
            <h5>Inbound Received</h5>
        </div>
        <div class="card-body">
            <table id="viewStatus" class="table table-striped" style="width: 100%;">
                <thead>
                    <th>No</th>
                    <th>No_Po</th>
                    <th>Jumlah Item</th>
                    <th>Quantity Item</th>
                    <th>Created Date</th>
                    <th>#</th>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $no = 1;
                        foreach ($data->getResultArray() as $user) :
                        ?>
                        <td><?= $no++; ?></td>
                        <td><?= $user['no_Po']; ?></td>
                        <td align="center">
                            <?php
                                $db = \Config\Database::connect();
                                $jumlah = $db->table('tbl_inbound')->where('nopo', $user['no_Po'])->countAllResults();
                                ?>
                            <span style="cursor:pointer; font-weight:bold; color:#0000FF;"
                                onclick="detail('<?= $user['no_Po']; ?>')"><?= $jumlah; ?></span>
                        </td>
                        <td><?= $user['quantity_item']; ?></td>
                        <td>
                            <?php
                                $db = \Config\Database::connect();
                                $jumlah = $db->table('tbl_po')->where('no_Po', $user['no_Po'])->countAllResults();
                                ?>
                            <?php if ($jumlah == null) : ?>
                            <?= $user['created_at'] ?>
                            <?php elseif ($jumlah != null) : ?>
                            <?= $user['updated_at'] ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                                $resi
                                ?>
                            <?php if ($jumlah == null) : ?>
                            <span style="font-weight:bold; color:green;" onclick="detail('<?= $user['No_Po']; ?>')"><i
                                    class="fa fa-check"></i> Done</span>
                            <?php elseif ($jumlah != null) : ?>

                            <button type="button" class="btn btn-sm btn-outline-info"
                                onclick="edit('<?= sha1($user['no_Po']); ?>')"><i class="fa fa-edit"></i>
                            </button>
                            <?php endif; ?>

                        </td>
                    </tr>
                    <?php endforeach; ?>

                    </tr>

                </tbody>
            </table>

        </div>
    </div>
</div>
<div class="viewmodal" style="display: none;"></div>
<script>
function edit(nopo) {
    window.location.href = ("<?= site_url('/inbound/edit/') ?>") + nopo;
}

function detail(nopo) {
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';
    $.ajax({
        type: "post",
        url: "<?= site_url('/inbound/detail') ?>",
        data: {
            [crsfToken]: crsfHash,
            nopo: nopo,
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

$(document).ready(function() {
    $('#viewStatus').DataTable();

    $("#inProses").click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "method",
            url: "url",
            data: "data",
            dataType: "dataType",
            success: function(response) {

            }
        });

    });
});
</script>
<?= $this->endsection('isi'); ?>