<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Packing Proses</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>
<style>
input[type=checkbox] {
    transform: scale(1.5);
}
</style>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <p>
                <button class="btn btn-sm btn-primary" type="button" onclick="location.href=('/Packing/index')"> <i
                        class="fa fa-backspace"></i> Back</button><br>
            </p>
            <table class="table table-sm table-striped table-hover" style="width:50%;">
                <tr>
                    <td style="width: 20%;"> Order Id</td>
                    <td style="width: 2%;"> : </td>
                    <td style="width: 50%;"> <?= $Order_id; ?></td>
                </tr><input type="hidden" name="OrderId" id="OrderId" value="<?= $Order_id; ?>">
                <input type="hidden" name="assign" id="assign" value="<?= $assign; ?>">
                <tr>
                    <td style="width: 20%;"> Date Receive</td>
                    <td style="width: 2%;"> : </td>
                    <td style="width: 20%;"> <?= $created_at ?></td>
                </tr>
                <tr>
                    <td style="width: 20%;"> Nama Penerima</td>
                    <td style="width: 2%;"> : </td>
                    <td style="width: 20%;"> <?= $Drop_name ?></td>
                </tr>
            </table><br>
            <button type="submit" class="btn btn-lg btn-info float-right" id="BtnSub"> Packing
                Done</button><br><br><br><br>
            <table id="viewStatus" class="table table-striped" style="width: 100%;">
                <thead>

                    <th>No</th>
                    <th>Item Id</th>
                    <th>Item Detail</th>
                    <th>Quantity</th>
                    <th>Aksi</th>
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
                        <td><?= $row['quantity']; ?></td>
                        <td><button type="button" class="btn btn-sm btn-danger" onclick="hapus('<?= $user->id; ?>')"><i
                                    class="fa fa-trash-alt"></i></button></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<script>
function hapus(id) {
    Swal.fire({
        title: 'Hapus Item',
        text: "Yakin hapus SKU ini ? ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Hapus Dong!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= site_url() ?>/Invoice/hapusSku",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        manifestTemp();
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Berhasil',
                            showConfirmButton: false,
                            timer: 1000
                        })
                        window.location.reload();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    })
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

function dataTemp() {
    let OrderId = $('#OrderId').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';
    $.ajax({
        type: "post",
        url: "/packing/dataTemp",
        data: {
            [crsfToken]: crsfHash,
            OrderId: OrderId
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


function ambilStock() {
    let itemId = $('#itemId').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';

    $.ajax({
        type: "post",
        url: "/Packing/ambilStock",
        data: {
            [crsfToken]: crsfHash,
            itemId: itemId
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                let data = response.sukses;
                $('#itemDetail').val(data.item);
                $('#qty').val(data.qty);
                $('#qtyRec').focus();
            }
            if (response.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Barang kosong..',
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
$('#BtnSub').click(function(e) {
    e.preventDefault();
    let jmlhCek = $('.centangId:checked');
    let assign = $('.assign').val();
    let OrderId = $('#OrderId').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';
    if (jmlhCek.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Warning',
            text: 'Item Belum Terpacking'
        });
        play_notifSalah()
    } else {
        Swal.fire({
            title: 'Proses Packing',
            text: `Packing ${jmlhCek.length} Items Now`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Proses Sekarang !'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('Packing/SubmitData') ?>",
                    data: {
                        [crsfToken]: crsfHash,
                        OrderId: OrderId,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Packing',
                                text: response.success,
                            });
                            window.location.href = ('/Packing/index/')
                            play_notif();
                        }
                    }
                });
            }
        });
    }

});

$('#tambahItem').click(function(e) {
    e.preventDefault();
    let OrderId = $('#OrderId').val();
    let itemId = $('#itemId').val();
    let itemDetail = $('#itemDetail').val();
    let assign = $('#assign').val();
    let qtyRec = $('#qtyRec').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';

    if (qtyRec.length == 0) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No Item Harus Di isi'
        });
        play_notifSalah();
    } else {
        $.ajax({
            type: "post",
            url: "/packing/simpanTemp",
            data: {
                [crsfToken]: crsfHash,
                qtyRec: qtyRec,
                itemId: itemId,
                itemDetail: itemDetail,
                OrderId: OrderId,
                assign: assign
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Berhasil'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                    play_notif();
                    kosong();
                }
                if (response.warning) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Opsss...',
                        text: response.warning
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                    play_notifSalah();
                    kosong();
                }
                if (response.warning1) {
                    Swal.fire({
                        title: 'Proses Packing',
                        text: "Barang tidak sesuai dengan orderan ? ",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Proses Sekarang !'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "post",
                                url: "/packing/simpanTemp1",
                                dataType: "json",
                                data: {
                                    [crsfToken]: crsfHash,
                                    qtyRec: qtyRec,
                                    itemId: itemId,
                                    itemDetail: itemDetail,
                                    OrderId: OrderId,
                                    assign: assign
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
                    });
                    play_notifSalah();
                    kosong();
                }
                if (response.error) {
                    Swal.fire({
                        icon: 'error',
                        text: response.error
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                    play_notifSalah();
                    kosong();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    }
});
$('#selesaiOut').click(function(e) {
    e.preventDefault();
    let OrderId = $('#OrderId').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';
    $.ajax({
        type: "post",
        url: "/Packing/Selesai",
        data: {
            [crsfToken]: crsfHash,
            OrderId: OrderId
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Berhasil'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = ('/Packing/index');
                    }
                });
            }
            play_notif();
        }
    });
});

$(document).ready(function() {
    $('#viewStatus').DataTable();
    dataTemp();
    $('#itemId').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            ambilStock();
        }
    });


});
</script>

<?= $this->endsection('isi'); ?>