<div class="modal fade" id="updateWarehouse" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Warehouse</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('MasterWarehouse/update', ['class' => 'formUpdate']) ?>
            <div class="modal-body">
                <div class="form-group">
                    <label for="codeBasket">Kode Basket</label>
                    <input type="text" class="form-control" name="id" id="id" aria-describedby="idWarehouse"
                        value="<?= $id ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="warehouse">Nama Warehouse</label>
                    <input type="text" class="form-control" name="warehouse" id="warehouse" aria-describedby="warehouse"
                        value="<?= $warehouse ?>">
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
            title: 'Tambah Warehouse',
            text: 'Yakin mau menambah Warehouse ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Buat Warehouse !'
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
    $('.formUpdate').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Update Warehouse',
            text: 'Yakin mau update Warehouse ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'update Warehouse !'
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
                                icon: 'success',
                                title: 'Berhasil..',
                                text: response.success,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
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