<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Daftar Acount</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
    rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


<div class="card">
    <div class="card-header bg-green">
        Daftar User Acount
    </div>
    <div class="card-body">
        <p>
            <button class="btn btn-info tambahData" type="submit" id="tambahData">
                <i class=" fa fa-plus"> Tambah User</i>
            </button>
        </p>
        <table id="table1" class="table table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID User</th>
                    <th>Nama User</th>
                    <th>Level</th>
                    <th>Warehouse</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if (user()->warehouse == 'Headoffice') {
                    $data = $data;
                } else {
                    $db = \Config\Database::connect();
                    $data = $db->table('tbl_karyawan')->where('warehouse', user()->warehouse)->get()->getResultArray();
                }
                foreach ($data as $row) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['id_user']; ?></td>
                    <td><?= $row['nama_user']; ?></td>
                    <td><?= $row['level'] ?></td>
                    <td><?= $row['warehouse'] ?></td>
                    <td>
                        <button class="btn btn-sm <?= $row['status_kar'] == 1 ? "btn-success" : "btn-danger" ?>"
                            onclick="status('<?= $row['id_user']; ?>')">
                            <?= $row['status_kar'] == 1 ? "Aktif" : "No Aktif" ?>
                        </button>
                    </td>
                    <td>
                        <button href="#" class="btn btn-sm btn-info" onclick="edit('<?= $row['id_user']; ?>')"><i
                                class="fa fa-pen-alt"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="hapusUser('<?= $row['id_user']; ?>')"><i
                                class="fa fa-trash-alt"></i>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="tambahUsers" style="display: none;"></div>
<div class="updateUser" style="display: none;"></div>

<script>
function status(users) {
    Swal.fire({
        title: 'Aktifkan/Noaktifkan',
        text: 'Update sekarang ? ',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Update !'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= site_url() ?>Karyawan/UpdateStatus",
                data: {
                    users: users
                },
                dataType: "json",
                success: function(response) {
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
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    })

}

function edit(users) {
    $.ajax({
        type: "post",
        url: "<?= site_url() ?>karyawan/updateData",
        data: {
            code: users,
        },
        dataType: "json",
        success: function(response) {

            if (response.data) {
                $('.updateUser').html(response.data).show();
                $('#updateUser').modal('show');

            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}

function play_notif() {
    var audio = document.createElement('audio');
    audio.setAttribute('src', '<?= site_url() ?>/dist/img/success.mp3');
    audio.setAttribute('autoplay', 'autoplay');
    audio.play();
    audio.load();
}

function hapusUser(iduser) {
    Swal.fire({
        title: 'Hapus Item',
        text: "Yakin untuk hapus barang ? ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= site_url('/Karyawan/deleteUser'); ?>",
                data: {
                    code: iduser
                },
                dataType: "json",
                success: function(response) {
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
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    })
}
$(document).ready(function() {
    $('#table1').DataTable();

    $('.tambahData').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('/Karyawan/modalTambah'); ?>",
            // dataType: "json",
            success: function(response) {
                $('.tambahUsers').html(response).show();
                $('#tambahUsers').on('show.bs.modal', function(event) {
                    $('#users').focus();
                })
                $('#tambahUsers').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

});
</script>
<?= $this->endsection('isi'); ?>