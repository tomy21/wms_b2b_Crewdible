<?= $this->extend('layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Return</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <p>
                            <button class="btn btn-sm btn-danger" type="button"
                                onclick="location.href=('/ReturnItem/index')"> <i class="fa fa-backspace"></i>
                                Back</button><br>
                        </p>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="">Item Id</label>
                                <input type="text" class="form-control" placeholder="Masukn Kode Item" id="OrderId"
                                    name="OrderId" value="">
                            </div>

                            <div class="form-group col-md-2">
                                <label for="">Aksi</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-info" title="Tambah Item" id="tambahItem"> <i
                                            class="fa fa-plus"></i> </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="tabelTampilData"></div>
<script>
function getDataReturn() {
    let OrderId = $('#OrderId').val();

    $.ajax({
        type: "post",
        url: "/ReturnItem/dataTemp",
        data: {
            OrderId: OrderId
        },
        dataType: "json",
        success: function(response) {
            if (response.data) {
                $('#tabelTampilData').html(response.data);

            }
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
$('#tambahItem').click(function(e) {
    e.preventDefault();
    let OrderId = $('#OrderId').val();
    let crsfToken = '<?= csrf_token() ?>';
    let crsfHash = '<?= csrf_hash() ?>';
    $.ajax({
        type: "post",
        url: "/ReturnItem/simpanData",
        data: {
            OrderId: OrderId,
            [crsfToken]: crsfHash,
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                Swal.fire({
                    icon: 'success',
                    title: 'Return sudah di terima',
                    text: response.sukses,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = ('/ReturnItem/index/');
                    }
                });
                play_notif();
            }
            if (response.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Order Tidak Ditemukan',
                    text: response.error,
                })
                play_notifSalah();
            }
        }
    });
});
$(document).ready(function() {
    $('#OrderId').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            getDataReturn();
        }
    });

});
</script>
<?= $this->endsection('isi'); ?>