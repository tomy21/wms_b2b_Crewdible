<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Inbound Proses</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<link rel="stylesheet" href="<?= base_url() ?>/dist/css/jquery.nice-number.css">
<script src="<?= base_url() ?>/dist/js/jquery.nice-number.js"></script>
<style>
.numberspin {
    border: none;
}
</style>

<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-danger">
            <h4>Proses Inbound</h4>
            <button class="btn btn-sm btn-danger" type="button"
                onclick="location.href=('<?= site_url('/Inbound/index') ?>')"> <i class="fa fa-backward"></i>
                Back</button>
        </div>
        <div class="card-body">
            <?= form_open(site_url('Inbound/simpanData'), ['class' => 'formInsertBatch']) ?>
            <div class="row">

                <div class="form-group col-md-6">
                    <label for="">Input No PO</label>
                    <input type="text" class="form-control" placeholder="No PO" name="nopo" id="nopo"
                        value="<?= $nopo ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Tanggal Inbound</label>
                    <input type="date" class="form-control" placeholder="No Faktur" name="tglfaktur" id="tglfaktur"
                        value="<?= date('Y-m-d') ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="">Warehouse</label>
                    <input type="text" class="form-control" placeholder="No Faktur" name="warehouse" id="warehouse"
                        value="<?= $warehouse ?>" readonly>
                </div>
            </div>

            <table class="table table-sm table-striped table-bordered" style="width: 100%;">
                <thead>
                    <th style="width: 5%;">No</th>
                    <th>Item Id</th>
                    <th>Item Detail</th>
                    <th>Qty kirim</th>
                    <th>Qty Good</th>
                    <th>Qty Bad</th>
                </thead>
                <tbody>
                <tbody>
                    <?php
                    $no = 1;

                    foreach ($datatemp as $row) :
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['Item_id']; ?></td>
                        <td><?= $row['Item_detail']; ?></td>
                        <td class="qtyGood"><?= $row['quantity']; ?></td>
                        <td style="text-align: center;">
                            <input type="number" id="qty" class="nice-number good" name="good[]" value="">
                        </td>
                        <td style="text-align: center;">
                            <input type="number" class="nice-number" name="bad[]" value="">
                        </td>
                        <input type="hidden" id="itemId" name="itemid[]" value="<?= $row['Item_id']; ?>">
                        <input type="hidden" name="itemdetail[]" value="<?= $row['Item_detail']; ?>">
                        <input type="hidden" name="qty[]" value="<?= $row['quantity']; ?>">
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="form-group">
                <button type="submit" class="form-control btn btn-sm btn-success"> Simpan </button>

            </div>
            <?= form_close(); ?>
            <div class="form-group">
                <button id="sesuai" class="form-control btn btn-sm btn-info"> Sudah sesuai </button>

            </div>
        </div>
    </div>
</div>
<div class="modalcaribarang" style="display: none;"></div>
<div class="modalInbound" style="display: none;"></div>
<script>
function ambilDataSKU() {
    let itemId = $('#itemId').val();
    $.ajax({
        type: "post",
        url: "<?= site_url('/inbound/ambilDataSKU') ?>",
        data: {
            [crsfToken]: crsfHash,
            ItemId: itemId
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                let data = response.sukses;
                // $('#namaSKU').val(data.Item_detail);
                $('#qty').val(data.quantity);
                // $('#qtyRec').focus();

            }
            if (response.error) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Barang Tidak Ditemukan..',
                    text: response.error,
                });
                kosong();
                dataTemp();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

function dataTemp() {
    let nopo = $('#nopo').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';
    $.ajax({
        type: "post",
        url: "<?= site_url('/inbound/dataTemp') ?>",
        data: {
            [crsfToken]: crsfHash,
            nopo: nopo
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

function kosong() {
    $('#nopo').val('');
    $('#namaSKU').val('');
    $('#qty').val('');
    $('#qtyRec').val('');
    $('#nopo').focus();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';
}

$(document).ready(function() {
    dataTemp();

    $('#sesuai').click(function(e) {
        $('.qtyGood').each(function(i, obj) {
            console.log($(this).text());
            var qty = $(this).text();
            var nextEl = $(this).next();
            var inputEl = nextEl.find('#qty');

            inputEl.val(qty);
        });

    });

    $('#tombolcariIn').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('/inbound/cariDataSKU') ?>",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.modalcaribarang').html(response.data).show();
                    $('#modalcaribarang').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });
    $('.formInsertBatch').submit(function(e) {
        e.preventDefault();
        let nopo = $('.nopo').val();
        let good = $('.good').val();
        let bad = $('.bad').val();
        let itemid = $('.itemid').val();
        let itemdetail = $('.itemdetail').val();
        let qty = $('.qty').val();

        if (good.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Quantity',
                text: 'Quantity Harus Diisi',
            })
        } else {
            Swal.fire({
                title: 'Input Inbound',
                text: 'Sudah yakin dengan quantitynya',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'input Sekarang !'
            }).then((result) => {
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Stock Sudah di Proses',
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
            });

        }


    });

    $('#inputsku').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            ambilDataSKU();
        }
    });
})

$(function() {
    $('input[type="number"]').niceNumber({

        // auto resize the number input
        autoSize: true,

        // the number of extra character
        autoSizeBuffer: 1,

        // custom button text
        buttonDecrement: '-',
        buttonIncrement: "+",

        // 'around', 'left', or 'right'
        buttonPosition: 'around',
        onDecrement: false,
        onIncrement: false,

    });
});
</script>

<?= $this->endsection('isi'); ?>