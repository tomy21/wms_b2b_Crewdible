<div class="modal fade" id="tambahUser" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-cyan">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <h2 class="card-header"><?= lang('Auth.register') ?></h2>
                    <div class="card-body register-card-body">
                        <p class="login-box-msg">Register <b>Crewdible</b>B2B
                        </p>
                        <?= view('Myth\Auth\Views\_message_block') ?>
                        <form action="<?= url_to('register') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="input-group mb-3">
                                <input type="text"
                                    class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>"
                                    placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>"
                                    name="username">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control " placeholder="Warehouse">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-warehouse"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email"
                                    class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                                    placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" name="email"
                                    aria-describedby="emailHelp">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="input-group mb-3">
                                <input type="password"
                                    class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                                    placeholder="<?= lang('Auth.password') ?>" autocomplete="off" name="password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password"
                                    class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                                    placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off"
                                    name="pass_confirm">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <!-- /.col -->
                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-success btn-block"><?= lang('Auth.register') ?></button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                        <br>

                    </div>
                    <!-- /.form-box -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function play_notif() {
    var audio = document.createElement('audio');
    audio.setAttribute('src', '<?= site_url() ?>/dist/img/success.mp3');
    audio.setAttribute('autoplay', 'autoplay');
    audio.play();
    audio.load();
}

function play_notifSalah() {
    var audio = document.createElement('audio');
    audio.setAttribute('src', '<?= site_url() ?>/dist/img/Salah2.mp3');
    audio.setAttribute('autoplay', 'autoplay');
    audio.play();
    audio.load();
}
$(document).ready(function() {
    $('.formtambahusers').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            cache: false,
            beforeSend: function() {
                $('.btnsimpan').prop('disable', true);
                $('.btnsimpan').html('<i class="fa fa-spinner></i>');
            },
            complete: function() {
                $('.btnsimpan').prop('disable', false);
                $('.btnsimpan').html('Simpan');
            },
            success: function(response) {
                if (response.error) {
                    let err = response.error;
                    if (err.users) {
                        $('#users').addClass('is-invalid');
                        $('#msg-users').html(err.users);
                    }
                    if (err.nama) {
                        $('#nama').addClass('is-invalid');
                        $('#msg-nama').html(err.nama);
                    }
                    if (err.pass) {
                        $('#pass').addClass('is-invalid');
                        $('#msg-pass').html(err.pass);
                    }
                    if (err.level) {
                        $('#level').addClass('is-invalid');
                        $('#msg-level').html(err.level);
                    }
                    if (err.warehouse) {
                        $('#warehouse').addClass('is-invalid');
                        $('#msg-warehouse').html(err.warehouse);
                    }
                } else {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = (
                                    '<?= site_url() ?>/Karyawan/index ');
                            }
                        });
                        play_notif();
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });

    });
});
</script>