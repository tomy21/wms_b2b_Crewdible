<?= $this->extend('layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Picking Proses</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="col-lg-12">
    <div class="card">

        <div class="card-body">
            <p>
                <button class="btn btn-sm btn-primary" type="button" onclick="location.href=('/Picking/index')"> <i
                        class="fa fa-backspace"></i> Back</button><br>
            </p>
            <div class="form-group col-md-2">
                <label for="">Nama Picker</label>
                <input type="text" class="form-control" id="assign" name="assign" value="<?= $picker; ?>" readonly>
            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="">Item Id</label>
                                <input type="text" class="form-control" placeholder="Masukn Kode Item" id="item_id"
                                    name="item_id" value="">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Nama Barang</label>
                                <input type="text" class="form-control" placeholder="Nama SKU" id="item_detail"
                                    name="item_detail" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Qty Stock</label>
                                <input type="number" class="form-control" id="qty" name="qty" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Qty Picking</label>
                                <input type="number" class="form-control" id="qtyIn" name="qtyIn">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="">Aksi</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-info" title="Tambah Item" id="tambahItem"> <i
                                            class="fa fa-plus"></i></button>&nbsp;
                                    <button id="btnDone" class="btn btn-success" title="Tombol Selesai"> <i
                                            class="fa fa-check"></i></button>
                                </div>
                            </div>
                        </div>
                        <table id="viewStatus" class="table table-striped" style="width: 100%;">
                            <thead>

                                <th>No</th>
                                <th>Item Id</th>
                                <th>Item Detail</th>
                                <th>Quantity</th>
                                <th>Qty Pick</th>
                            </thead>
                            <tbody>
                                <?php
                                $nomor = 1;
                                foreach ($data->getResultArray() as $row) :
                                ?>
                                <tr>
                                    <td><?= $nomor++; ?></td>
                                    <td><?= $row['Item_id']; ?></td>
                                    <td><?= $row['Item_detail']; ?></td>
                                    <td><?= $row['qty']; ?></td>
                                    <td>
                                        <?= $row['quantity_pick']; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modalScanPick" style="display: none;"></div>
<script>
$(document).ready(function() {
    $('#viewStatus').DataTable();

});

function ambilStock() {
    let item_id = $('#item_id').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';

    $.ajax({
        type: "post",
        url: "/Picking/ambilStock",
        data: {
            Item_id: item_id,
            [crsfToken]: crsfHash,
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                let data = response.sukses;
                $('#item_detail').val(data.item);
                $('#qty').val(data.qty);
                $('#qtyIn').focus();
            }
            if (response.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Opsss...',
                    text: response.error,
                });
                kosong();
                play_notifSalah();
            }

        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

$(document).ready(function() {
    $('#viewStatus').DataTable();

    $('#item_id').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            ambilStock();
        }
    });
    $('#qtyIn').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            let assign = $('#assign').val();
            let item_id = $('#item_id').val();
            let qtyIn = $('#qtyIn').val();
            let crsfToken = '<?= csrf_token() ?>';
            let crsfHash = '<?= csrf_hash() ?>';

            if (qtyIn.length == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No Item Harus Di isi'
                });
                play_notifSalah();
            } else {
                $.ajax({
                    type: "post",
                    url: "/picking/simpanTemp",
                    data: {
                        [crsfToken]: crsfHash,
                        qtyIn: qtyIn,
                        item_id: item_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                    $('#item_id').focus();
                                }
                            });
                            play_notif();
                            kosong();
                        }
                        if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.error
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                            play_notifSalah();
                            kosong();
                        }
                        if (response.warning) {
                            Swal.fire({
                                title: 'quantity Kurang dari order?',
                                text: response.warning,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Tetap Input!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        type: "post",
                                        url: "/picking/simpanTemp1",
                                        dataType: "json",
                                        data: {
                                            [crsfToken]: crsfHash,
                                            qtyIn: qtyIn,
                                            item_id: item_id,
                                        },
                                        success: function(response) {
                                            if (response.success) {
                                                Swal.fire({
                                                    position: 'center',
                                                    icon: 'success',
                                                    title: 'Berhasil'
                                                }).then((
                                                    result) => {
                                                    if (result
                                                        .isConfirmed
                                                    ) {
                                                        window
                                                            .location
                                                            .reload();
                                                    }
                                                });
                                                play_notif();
                                                kosong();
                                            }
                                        }
                                    });
                                }
                            })
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + thrownError);
                    }
                });
            }
        }

    });

});

function kosong() {
    $('#item_id').val('');
    $('#item_detail').val('');
    $('#qty').val('');
    $('#noAwb').focus();
}

function play_notif() {
    var audio = document.createElement('audio');
    audio.setAttribute('src', '<?= base_url() ?>/dist/img/success.mp3');
    audio.setAttribute('autoplay', 'autoplay');
    audio.play();
    audio.load();
}

function play_notifSalah() {
    var audio = document.createElement('audio');
    audio.setAttribute('src', '<?= base_url() ?>/dist/img/Salah2.mp3');
    audio.setAttribute('autoplay', 'autoplay');
    audio.play();
    audio.load();
}
$(document).ready(function() {

    $('#item_id').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
        }
    });

    $('#btnDone').click(function(e) {
        e.preventDefault();
        let assign = $('#assign').val();
        let crsfToken = '<?= csrf_token() ?>';
        let crsfHash = '<?= csrf_hash() ?>';
        Swal.fire({
            title: 'Apakah sudah semua di Picking ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Selesai'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "/picking/SimpanPicking",
                    data: {
                        [crsfToken]: crsfHash,
                        assign: assign,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sudah Di Picking',
                                text: response.success,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.history.back();
                                }
                            });
                            kosong();
                            play_notif();
                        }
                        if (response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal selesaikan Picking',
                                text: response.error,
                            });
                            kosong();
                            play_notifSalah();
                        }
                    }
                });
            }
        })
    });


    $('#tambahItem').click(function(e) {
        e.preventDefault();
        let assign = $('#assign').val();
        let item_id = $('#item_id').val();
        let qtyIn = $('#qtyIn').val();
        let crsfToken = '<?= csrf_token() ?>';
        let crsfHash = '<?= csrf_hash() ?>';

        if (qtyIn.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No Item Harus Di isi'
            });
            play_notifSalah();
        } else {
            $.ajax({
                type: "post",
                url: "/picking/simpanTemp",
                data: {
                    [crsfToken]: crsfHash,
                    qtyIn: qtyIn,
                    item_id: item_id,
                    assign: assign
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Berhasil'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                                $('#item_id').focus();
                            }
                        });
                        play_notif();
                        kosong();
                    }
                    if (response.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                        play_notifSalah();
                        kosong();
                    }
                    if (response.warning) {
                        Swal.fire({
                            title: 'quantity Kurang dari order?',
                            text: response.warning,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Tetap Input!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "post",
                                    url: "/picking/simpanTemp1",
                                    dataType: "json",
                                    data: {
                                        [crsfToken]: crsfHash,
                                        qtyIn: qtyIn,
                                        item_id: item_id,
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'success',
                                                title: 'Berhasil'
                                            }).then((result) => {
                                                if (result
                                                    .isConfirmed
                                                ) {
                                                    window
                                                        .location
                                                        .reload();
                                                }
                                            });
                                            play_notif();
                                            kosong();
                                        }
                                    }
                                });
                            }
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    });
});
</script>
<?= $this->endsection('isi'); ?>