<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Picking Assign</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<div class="section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-green">
                        Menu Transaksi
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="">Pilih barang</label>
                                <div class="input-group">
                                    <button class="btn btn-sm btn-outline-info" type="submit" id="tombolcariIn"
                                        name="tombolcariIn">
                                        List Barang
                                    </button>
                                </div>
                            </div>
                            <div class="form-group col-md-10">
                                <label for="">Date Outbound</label>
                                <input type="datetime" class="form-control" id="tglInvoice" name="tglout"
                                    placeholder="Last name" value="<?= date('Y-m-d H:i:s'); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-green">
                        Summary order
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="transaksi" class="col-sm-9 col-form-label">Total Order</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" id="transaksi" value="<?= $countOrder ?>"
                                    style="border:none; background-color:transparent; font-size:24px; font-weight:bold;">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pembayaran" class="col-sm-9 col-form-label">Total Quantity</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="pembayaran" value="<?= $total ?>" min="0"
                                    style="border:none; background-color:transparent; font-size:24px; font-weight:bold;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="kembali" class="col-sm-9 col-form-label">Estimasi Basket</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="totBasket" value=""
                                    style="border:none; background-color:transparent; font-size:24px; font-weight:bold;"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kembali" class="col-sm-3 col-form-label">Basket Ready</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="readyBasket" value=""
                                    style="border:none; background-color:transparent; font-size:24px; font-weight:bold;"
                                    readonly>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tabelTampilData"></div>
<div class="modalbarang" style="display: none;"></div>
<script>
function simpanItem() {
    let picker = $('#picker').val();
    let basket = $('#basket').val();
    let inputSKU = $('#inputsku').val();
    let namaSKU = $('#namaSKU').val();
    let qtyOut = $('#qtyOut').val();

    if (inputSKU.length == 0) {
        Swal.fire('Error', 'Code Barang Harus Dimasukan', 'error');
        kosong();
    } else if (qtyOut.length == 0) {
        Swal.fire('Perhatian', 'Quantity Barang Harus Diisi', 'warning');
        $('#qtyOut').focus();
    } else {
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>/assign/simpanData",
            data: {
                picker: picker,
                basket: basket,
                codeSKU: inputSKU,
                namaSKU: namaSKU,
                qtyOut: qtyOut
            },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.error,
                    });
                    kosong();
                }
                if (response.sukses) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil..',
                        text: response.sukses,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                    tampilDataTemp();
                    kosong();

                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }
}

function dataTemp() {
    let invoice = $('#noInvoice').val();
    $.ajax({
        type: "post",
        url: "<?= site_url() ?>/Assign/dataTemp",
        data: {
            invoice: invoice
        },
        dataType: "json",
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
    dataTemp();

    $('#inputsku').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            ambilDataBarang();
        }
    });

    $('#tombolcariIn').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('/Assign/cariBarang') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.modalbarang').html(response.data).show();
                    $('#modalbarang').modal('show');


                }
            }
        });
    });
    $('#tambahItem').click(function(e) {
        e.preventDefault();
        simpanItem();
    });
});
</script>
<?= $this->endsection('isi'); ?>