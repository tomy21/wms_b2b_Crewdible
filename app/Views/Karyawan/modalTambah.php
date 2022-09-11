<div class="modal fade" id="tambahUsers" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                <?= form_open('Karyawan/tambahUsers', ['class' => 'formtambahusers']) ?>
                <div class="form-row">
                    <div class="col-6">
                        <label for="">Id Users</label>
                        <input type="text" class="form-control" id="users" name="users" value="<?= $id ?>"
                            autocomplete="off" readonly>
                        <div id="msg-users" class="invalid-feedback">

                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="nama">Nama Users</label>
                            <input type="text" class="form-control" id="nama" name="nama" autocomplete="off">
                            <div id="msg-nama" class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="pass">Password</label>
                            <input type="password" class="form-control" id="pass" name="pass" autocomplete="off">
                            <div id="msg-pass" class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="warehouse">Warehouse</label>
                            <input type="text" class="form-control" id="warehouse" name="warehouse" autocomplete="off"
                                value="<?= $warehouse ?>" readonly>
                            <div id="msg-warehouse" class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="warehouse">Email</label>
                            <input type="email" class="form-control" id="email" name="email" autocomplete="off"
                                value="">
                            <div id="msg-email" class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="jenisbarang">Level</label>
                            <select class="form-control" id="level" name="level">
                                <option value="" selected> - Pilih Jenis -</option>
                                <option value="picker">Picker</option>
                                <option value="packer">Packer</option>
                                <option value="sorter">Sorter</option>
                                <option value="Multi">Multi</option>
                            </select>
                            <div id="msg-level" class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btnsimpan">Simpan</button>
                    <?= form_close(); ?>
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