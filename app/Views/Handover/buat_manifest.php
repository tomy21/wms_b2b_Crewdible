<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>List Handover</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header bg-danger">
            <h4>Create Manifest</h4>
            <button class="btn btn-sm btn-secondary" type="button"> <i class="fa fa-backward"></i> Back</button>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Id_Handover</label>
                    <input type="text" id="idHandover" class="form-control" value="<?= $idHandover; ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="">Masukan Driver</label>
                    <input type="text" id="driver" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Masukan No Order</label>
                    <input type="text" id="orderId" class="form-control">
                </div>

            </div>

            <p>*Note : Lakukan scan dahulu baru lakukan submit</p>
            <p>
                <button type="button" class="btn btn-success" id="btnSubmit">Submit</button>
            </p>
            <table id="view" class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Order Id</th>
                        <th>Driver</th>
                        <th>Nama Penerima</th>
                        <th>Alamat</th>
                        <th>No Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($query as $y) :
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $y->order_id ?></td>
                        <td><?= $y->driver ?></td>
                        <td><?= $y->nama_penerima ?></td>
                        <td><?= $y->alamat ?></td>
                        <td><?= $y->no_tlp ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
</div>
<script>
function kosong() {
    $('#orderId').val('');
    $('#orderId').focus();
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
    $('#btnSubmit').click(function(e) {
        e.preventDefault();
        let id = $('#idHandover').val();
        Swal.fire({
            title: 'Apakah sudah selesai ?',
            text: "Yakin sudah mau menyimpan manifest",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Simpan !'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: "<?= site_url() ?>/Handover/simpanData",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.error) {
                            Swal.fire({
                                title: 'Error',
                                icon: 'error',
                                text: response.error
                            });
                        }
                        if (response.sukses) {
                            Swal.fire({
                                title: 'Berhasil',
                                icon: 'success',
                                text: response.sukses
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
            }
        })
    });
    $('#orderId').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            let order = $('#orderId').val();
            let driver = $('#driver').val();
            let idHandover = $('#idHandover').val();
            if (order.length === 0) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Order Tidak Boleh Kosong',
                    showConfirmButton: false,
                    timer: 1000
                });
                kosong()
                play_notifSalah();
            } else if (driver.length < 1) {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: 'Driver harus di isi',
                    showConfirmButton: false,
                    timer: 1000
                });
                play_notifSalah();
            } else {
                $.ajax({
                    type: "post",
                    url: "<?= site_url() ?>/Handover/simpanTemResi",
                    data: {
                        order: order,
                        driver: driver,
                        idHandover: idHandover
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#tampilDataManifest').html(
                            '<i class="fa fa-spin fa-spinner"</i>')
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil',
                                showConfirmButton: false,
                                timer: 1000
                            });
                            kosong();
                            play_notif();
                        }
                        if (response.error) {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: response.error,
                                showConfirmButton: false,
                                timer: 1000
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
        }
    });


});
</script>
<?= $this->endsection('isi'); ?>