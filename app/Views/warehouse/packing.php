<?= $this->extend('layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Packing</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>



<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-danger">
                <h3 class="card-title">Input Item</h3>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <select class="form-control select2" name="assign" id="assign">
                                    <option>- Pilih Order Id -</option>
                                    <?php
                                    $db = \Config\Database::connect();
                                    $jumlah = $db->table('tbl_invoice')->select('Order_id,Assign,Item_id,Item_detail,status, sum(quantity) as jumlah, count(Order_id) as qty,count(Assign) as assign')
                                        ->groupBy('Order_id')->get();
                                    ?>
                                    <?php foreach ($jumlah->getResultArray() as $row) : ?>
                                    <option style="color: black;" value="<?= $row['Order_id'] ?>">
                                        <?= $row['Order_id'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <p>
                                <button class="btn btn-sm btn-info" id="btnPilih">Filter</button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-danger">
                <h3 class="card-title">List Items</h3>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="row" id="dataItem">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tabelTampilData"></div>



<script>
function dataTemp() {
    let assign = $('#assign').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';
    $.ajax({
        type: "post",
        url: "/packing/dataTemp",
        data: {
            [crsfToken]: crsfHash,
            assign: assign
        },
        dataType: "json",
        beforeSend: function() {
            $('#dataItem').html('<i class="fa fa-spin fa-spinner"</i>')
        },
        success: function(response) {
            if (response.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data Kosong',
                    text: response.error,
                });
            }
            if (response.data) {
                $('#dataItem').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

function orderData() {
    let assign = $('#assign').val();
    $.ajax({
        type: "post",
        url: "/packing/dataTemp2",
        data: {
            assign: assign
        },
        dataType: "json",
        beforeSend: function() {
            $('#tabelTampilData').html('<i class="fa fa-spin fa-spinner"</i>')
        },
        success: function(response) {

            if (response.data) {
                $('#tabelTampilData').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}


$(document).ready(function() {
    orderData();

    $('#item_id').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            ambilStock();
        }
    });
});
$(document).ready(function() {
    $('#btnPilih').click(function(e) {
        e.preventDefault();
        dataTemp();
        orderData();
    });
});
</script>
<script>
$(function() {
    $('.select2').select2()
});
</script>

<?= $this->endsection('isi'); ?>