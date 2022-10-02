<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Basket Master</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<?php if (user()->warehouse == null) {
    session()->destroy();
    return redirect()->to('login/index');
} ?>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="form-group col-md-2">
                <div class="input-group">
                    <button class="btn btn-info" title="tambah" id="tambahBasket"> Tambah Basket
                    </button>
                </div>
            </div>
            <table id="viewStatus" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Basket Id</th>
                        <th>Warehouse</th>
                        <th>Type</th>
                        <th>Kapasitas</th>
                        <th>Barcode</th>
                        <th>#</th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $db = \Config\Database::connect();
                    if (user()->warehouse == 'Headoffice') {
                        $data = $db->table('tbl_masterbasket')->get()->getResult();
                    } else {
                        $data = $db->table('tbl_masterbasket')->where('warehouse', user()->warehouse)->get()->getResult();
                    }



                    foreach ($data as $row) :
                    ?>

                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row->id_basket ?></td>
                        <td><?= $row->warehouse ?></td>
                        <td><?= $row->type ?></td>
                        <td><?= $row->kapasitas ?></td>
                        <td>
                            <?php
                                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($row->id_basket, $generator::TYPE_CODE_128)) . '">';

                                ?>
                        </td>
                        <td>
                            <a href="<?= base_url('Basket/printBasket/' . $row->id_basket) ?>"
                                class="btn btn-sm btn-warning" target="_blank"> <i class="fa fa-print"></i></a>
                            <button class="btn btn-sm btn-danger" onclick="hapus('<?= $row->id_basket ?>')"><i
                                    class="fa fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modalBasket" style="display: none;"></div>

<script>
function hapus(idBasket) {
    Swal.fire({
        title: 'Hapus Basket',
        text: "Yakin untuk hapus basket ? ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= site_url('/Basket/hapusBasket') ?>",
                data: {
                    idBasket: idBasket
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = (
                                    '<?= site_url() ?>/Basket/index ');
                            }
                        });
                    }
                }
            });
        }
    })

}
$('#tambahBasket').click(function(e) {
    e.preventDefault();
    $.ajax({
        url: "<?= site_url() ?>/Basket/modalBasket",
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('.modalBasket').html(response.data).show();
                $('#modalBasket').modal('show');
            }
        }
    });
});
</script>

<?= $this->endsection('isi'); ?>