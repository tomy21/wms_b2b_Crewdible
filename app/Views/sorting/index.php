<?php if (user()->foto == null) {
    session()->destroy();
    return redirect()->to('login/index');
} ?>
<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Sorting</h1>
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
                            <div class="form-group col-md-6">
                                <label for="">Id Basket </label>
                                <input type="text" class="form-control" id="idBasket" name="IdBasket" value="" autofocus>
                            </div>
                            <div class="form-group col">
                                <label for="">Date Outbound</label>
                                <input type="datetime" class="form-control" id="tglInvoice" name="tglout" placeholder="Last name" value="<?= date('Y-m-d H:i:s'); ?>" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="tabelTampilData"></div>

<script>
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
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>/Sorting/dataTemp",

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

        $('#idBasket').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                let id = $('#idBasket').val();
                $.ajax({
                    type: "post",
                    url: "<?= site_url() ?>/Sorting/postDataSorting",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Berhasil',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                    play_notif()
                                }

                            });
                        }
                        if (response.error) {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: response.error,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    play_notifSalah()
                                    window.location.reload();
                                }

                            });
                        }
                    }
                });
            }
        });
    });
</script>

<?= $this->endsection('isi'); ?>