<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
    rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<div class="modal fade" id="updateUser" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-cyan">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open(site_url('Karyawan/UpdateUser'), ['class' => 'formupdateusers']) ?>
                <div class="form-row">
                    <div class="col-6">
                        <label for="">Id Users</label>
                        <input type="text" class="form-control" id="users" name="users" value="<?= $id_user ?>"
                            autocomplete="off" readonly>
                        <div id="msg-users" class="invalid-feedback">

                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label for="nama">Nama Users</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama_user ?>"
                                autocomplete="off">
                            <div id="msg-nama" class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="nama">Password</label>
                            <input type="password" class="form-control" id="pass" name="pass" value="<?= $password ?>"
                                autocomplete="off">
                            <div id="msg-nama" class="invalid-feedback">

                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="nama">Warehouse</label>
                            <input type="text" class="form-control" id="warehouse" name="warehouse"
                                value="<?= $warehouse ?>" autocomplete="off">
                            <div id="msg-warehouse" class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="jenisbarang">Level</label>
                            <select class="form-control" id="level" name="level">
                                <option value="<?= $level ?>" selected><?= $level ?></option>
                                <option value="picker">Picker</option>
                                <option value="packer">Packer</option>
                                <option value="all">All</option>
                            </select>
                            <div id="msg-level" class="invalid-feedback">

                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input type="checkbox" <?= ($status == '1') ? 'checked' : ''; ?> data-toggle="toggle"
                                data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger"
                                data-width="150px" class="chStatus" name="status">
                        </div>
                    </div><br>
                    <button type=" submit" class="btn btn-success btnsimpan" style="width:100%">Simpan</button>
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
    $('.chStatus').change(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>Karyawan/UpdateStatus",
            data: {
                users: $('#users').val(),
            },
            dataType: "json",
            success: function(response) {
                if (response.success == '') {
                    window.location.reload();
                }
            }
        });
    });
    $('.formupdateusers').submit(function(e) {
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

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
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

    });
});
</script>