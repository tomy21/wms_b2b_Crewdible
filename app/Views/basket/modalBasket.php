<div class="modal fade" id="modalBasket" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Basket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('Basket/addBasket', ['class' => 'formBasket']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="codeBasket">Kode Basket</label>
                    <input type="text" class="form-control" name="idbasket" id="codeBasket"
                        aria-describedby="CodeBasket" value="<?= $idBasket ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="warehouse">Kode Basket</label>
                    <input type="text" class="form-control" name="warehouse" id="warehouse" aria-describedby="warehouse"
                        value="<?= user()->warehouse ?>" readonly>
                </div>
                <div class="form-group row">
                    <label for="panajng" class="col-sm-3 col-form-label">Panjang</label>
                    <div class="col-sm-9">
                        <input type="text" name="panjang" class="form-control" id="panjang" value="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lebar" class="col-sm-3 col-form-label">lebar</label>
                    <div class="col-sm-9">
                        <input type="text" name="lebar" class="form-control" id="lebar" value="" min="0">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tinggi" class="col-sm-3 col-form-label">tinggi</label>
                    <div class="col-sm-9">
                        <input type="text" name="tinggi" class="form-control" id="tinggi" value="" min="0">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>

            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>


<script>
function cariSKUbarang() {
    let cari = $('#cari').val();
    $.ajax({
        type: "post",
        url: "<?= site_url() ?>/Picking/CariDetailBarang",
        data: {
            cari: cari
        },
        dataType: "json",
        beforeSend: function(response) {
            $('.listbarang').html('<i class="fa fa-spin fa-spinner"</i>')
        },
        success: function(response) {
            if (response.data) {
                $('.listbarang').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}


$(document).ready(function() {
    $('#btnCariBarang').click(function(e) {
        e.preventDefault();
        cariSKUbarang();
        $('#panjang').focus();

    });

    $('#cari').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            cariSKUbarang();
        }
    });
    $('#view').DataTable();
    $('#centangsemua').click(function(e) {
        if ($(this).is(':checked')) {
            $('.centangId').prop('checked', true);
        } else {
            $('.centangId').prop('checked', false);
        }
    });

    $('.formBasket').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Tambah Basket',
            text: 'yakin mau menambah basket ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Buat basket !'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.success,
                                showConfirmButton: false,
                                timer: 1000
                            });
                            window.location.reload();
                            play_notif();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        });


    });
});
</script>