<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Daftar Acount</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
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
                foreach ($data as $row) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['id_user']; ?></td>
                    <td><?= $row['nama_user']; ?></td>
                    <td><?= $row['level'] ?></td>
                    <td><?= $row['warehouse'] ?></td>
                    <td>
                        <?php if ($row['status_kar'] == 1) : ?>
                        <span class="badge badge-success">Active</span>
                        <?php else : ?>
                        <span class="badge badge-danger">Non Active</span>
                        <?php endif; ?>
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
<!-- <div class=" card">
            <div class="card-header bg-white">

            </div>
            <div class="card-body">
                <div class="row" id="tampilDataManifest">
                </div>
            </div>
    </div> -->
<div class="tambahUsers" style="display: none;"></div>
<div class="updateUser" style="display: none;"></div>

<script>
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