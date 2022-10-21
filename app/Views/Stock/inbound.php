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
                    <th>Warehouse</th>
                    <th>Driver</th>
                    <th>Foto Barang</th>
                    <th>Foto Surat Jalan</th>
                    <th>Jumlah Item</th>
                    <th>Quantity Item</th>
                    <th>Selisih</th>
                    <th>Selesai Inbound</th>
                    <th>#</th>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $no = 1;
                        $db = \Config\Database::connect();
                        if (user()->warehouse == 'Headoffice') {
                            $admin = $db->table('tbl_po')->get()->getResultArray();
                        } else {
                            $warehouse = $db->table('tbl_po')->where(['warehouse' => user()->warehouse])->get()->getResultArray();
                        }
                        user()->warehouse == 'Headoffice' ? $inbound = $admin : $inbound = $warehouse;
                        foreach ($inbound as $user) :
                        ?>
                        <td style="vertical-align: middle ;"><?= $no++; ?></td>
                        <td style="vertical-align: middle ;"><?= $user['no_Po']; ?></td>
                        <td style="vertical-align: middle ;"><?= $user['warehouse'] ?></td>
                        <td style="vertical-align: middle ;"><?= $user['driver'] ?></td>
                        <td style="vertical-align: middle ;" align="center"><img
                                src="<?= site_url() ?>/assets/inbound/<?= $user['foto'] ?>" alt="" width="50"></td>
                        <td style="vertical-align: middle ;" align="center"><img
                                src="<?= site_url() ?>/assets/inbound/<?= $user['tandatangan'] ?>" alt="" width="50">
                        </td>
                        <td style="vertical-align: middle ;" align="center">
                            <?php
                                $db = \Config\Database::connect();
                                $jumlah = $db->table('tbl_inbound')->where('nopo', $user['no_Po'])->countAllResults();
                                ?>
                            <span style="cursor:pointer; font-weight:bold; color:#0000FF;"
                                onclick="detail('<?= $user['no_Po']; ?>')"><?= $jumlah; ?></span>
                        </td>
                        <td style="vertical-align: middle ;"><?= $user['quantity_item']; ?></td>
                        <td style="vertical-align: middle ;"><?= $user['selisih']; ?></td>
                        <td style="vertical-align: middle ;"><?= $user['updated_at'] ?></td>
                        <td style="vertical-align: middle ;">
                            <?php
                                $resi
                                ?>
                            <?php if ($user['status'] == 2) : ?>
                            <span class="badge badge-success"><i class="fa fa-check"></i> Done</span>
                            <?php elseif ($user['status'] == 0) : ?>
                            <span class="badge badge-danger"> Dalam Perjalanan</span>
                            <?php elseif ($user['status'] == 1) : ?>
                            <button type="button" class="btn btn-sm btn-outline-info"
                                onclick="edit('<?= $user['no_Po']; ?>')"><i class="fa fa-edit"></i>
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