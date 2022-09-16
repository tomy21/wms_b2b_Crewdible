<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Basket Master</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
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

                    $data = $db->table('tbl_masterbasket')->where('warehouse', user()->warehouse)->get()->getResult();


                    foreach ($data as $row) :
                    ?>

                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['id_basket'] ?></td>
                        <td><?= $row['type'] ?></td>
                        <td><?= $row['kapasitas'] ?></td>
                        <td>
                            <?php
                                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                                echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($row['id_basket'], $generator::TYPE_CODE_128)) . '">';

                                ?>
                        </td>
                        <td>
                            <a href="<?= base_url('Basket/printBasket/' . $row['id_basket']) ?>"
                                class="btn btn-sm btn-danger" target="_blank"> <i class="fa fa-print"></i></a>
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