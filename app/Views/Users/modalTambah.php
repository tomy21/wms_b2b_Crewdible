<div class="modal fade" id="tambahUser" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-cyan">
                <h5 class="modal-title" id="staticBackdropLabel"><?= lang('Auth.register') ?> Warehouse</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="login-box-msg">Register <b>Crewdible</b>B2B
                </p>
                <?= view('Myth\Auth\Views\_message_block') ?>
                <form action="<?= url_to('register') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="input-group mb-3">
                        <input type="text"
                            class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>"
                            placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>" name="username"
                            autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <select name="warehouse" id="warehouse"
                            class="form-control <?php if (session('errors.warehouse')) : ?>is-invalid<?php endif ?>"
                            required>
                            <option value="" selected disabled> -- Pilih Warehouse -- </option>
                            <?php
                            $db = \Config\Database::connect();
                            $basket = $db->table('tbl_warehouse')->get()->getResult();
                            foreach ($basket as $row) :
                            ?>
                            <option value="<?= $row->warehouse_name ?>"><?= $row->warehouse_name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-warehouse"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-4">
                        <select name="role" id="role" class="form-control" required>
                            <option value="" selected disabled> -- pilih Role -- </option>
                            <?php
                            $db = \Config\Database::connect();
                            $basket = $db->table('auth_groups')->get()->getResult();
                            foreach ($basket as $row) :
                            ?>
                            <option value="<?= $row->name ?>"><?= $row->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-users"></span>
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
                            placeholder="<?= lang('Auth.password') ?>" autocomplete="off" name="password" id="pass">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span id="btnHide" onclick="change()">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                        <path fill-rule="evenodd"
                                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                    </svg>

                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password"
                            class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                            placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off" name="pass_confirm"
                            id="pass_confirm">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span id="btnHide2" onclick="change2()">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                        <path fill-rule="evenodd"
                                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                    </svg>

                                </span>
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
                <!-- /.form-box -->

            </div>
        </div>
    </div>
</div>

<script>
function change() {

    // membuat variabel berisi tipe input dari id='pass', id='pass' adalah form input password 
    var x = document.getElementById('pass').type;

    //membuat if kondisi, jika tipe x adalah password maka jalankan perintah di bawahnya
    if (x == 'password') {

        //ubah form input password menjadi text
        document.getElementById('pass').type = 'text';

        //ubah icon mata terbuka menjadi tertutup
        document.getElementById('btnHide').innerHTML =
            `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829z"/><path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/></svg>`;
    } else {

        //ubah form input password menjadi text
        document.getElementById('pass').type = 'password';

        //ubah icon mata terbuka menjadi tertutup
        document.getElementById('btnHide').innerHTML =
            `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
        <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>`;
    }
}

function change2() {

    // membuat variabel berisi tipe input dari id='pass', id='pass' adalah form input password 
    var x = document.getElementById('pass_confirm').type;

    //membuat if kondisi, jika tipe x adalah password maka jalankan perintah di bawahnya
    if (x == 'password') {

        //ubah form input password menjadi text
        document.getElementById('pass_confirm').type = 'text';

        //ubah icon mata terbuka menjadi tertutup
        document.getElementById('btnHide2').innerHTML =
            `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829z"/><path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/></svg>`;
    } else {

        //ubah form input password menjadi text
        document.getElementById('pass_confirm').type = 'password';

        //ubah icon mata terbuka menjadi tertutup
        document.getElementById('btnHide2').innerHTML =
            `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
        <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/></svg>`;
    }
}

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