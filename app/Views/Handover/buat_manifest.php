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
            <button class="btn btn-sm btn-secondary" type="button"
                onclick="location.href=('<?= site_url('/Handover/index') ?>')"> <i class=" fa fa-backward"></i>
                Back</button>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Id_Handover</label>
                    <input type="text" id="idHandover" class="form-control" value="<?= $idHandover; ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="">Masukan No Order</label>
                    <input type="text" id="orderId" class="form-control">
                </div>
            </div>
            <div class="row">


            </div>

            <p>*Note : Lakukan scan dahulu baru lakukan submit</p>


        </div>

    </div>
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="float-left">Table Manifest</h5></br>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-8">
                    <input type="text" id="driver" class="form-control" placeholder="Masukan nama driver">
                </div>
                <div class="form-group col-md-4">
                    <button class="btn btn-success" title="Simpan Manifest" id="btnSubmit"><i class="fa fa-save"></i>
                        Selesai</button>
                </div>
            </div>
            <div class="row" id="tampilDataManifest">
    
            </div>
        </div>
    </div>
</div>
</div>
<script>
function kosong() {
    $('#orderId').val('');
    $('#orderId').focus();
}

function manifestTemp() {
    let driver = $('#driver').val();
    // let logistic = $('#logistic').val();
    $.ajax({
        type: "post",
        url: "<?= site_url() ?>/Handover/Manifest_Temp",
        data: {
            driver: driver,
            // logistic: logistic
        },
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('#tampilDataManifest').html(response.data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
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
    manifestTemp();
    $('#orderId').focus();
    $('#btnSubmit').click(function(e) {
        e.preventDefault();
        let id = $('#idHandover').val();
        let driver = $('#driver').val();
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
                        id: id,
                        driver: driver,
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
                                    $('#driver').val('#driver');

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
                            window.location.reload();
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
                            window.location.reload();
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