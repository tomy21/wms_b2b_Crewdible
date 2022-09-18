<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Management Users</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
    rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


<div class="card">
    <div class="card-header bg-green">
        User Management
    </div>
    <div class="card-body">
        <p>
            <button class="btn btn-info tambahData" type="submit" id="tambahData">
                <i class=" fa fa-plus"> Tambah User</i>
            </button>
        </p>
        <?= view('Myth\Auth\Views\_message_block') ?>
        <table id="table1" class="table table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Email Users</th>
                    <th>Nama Users</th>
                    <th>Level</th>
                    <th>Warehouse Name</th>
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
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['username']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['warehouse']; ?></td>
                    <td>
                        <input type="hidden" value="<?= $row['userId'] ?>" id="users">
                        <input type="checkbox" <?= ($row['active'] == '1') ? 'checked' : ''; ?> data-toggle="toggle"
                            data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger"
                            data-width="120px" class="chStatus" name="status">
                    </td>
                    <td>
                        <button href="#" class="btn btn-sm btn-info" onclick="edit('<?= $row['userId']; ?>')"><i
                                class="fa fa-pen-alt"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="hapusUser('<?= $row['userId']; ?>')"><i
                                class="fa fa-trash-alt"></i>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="tambahUser" style="display: none;"></div>
<div class="updateUsers" style="display: none;"></div>

<script>
function edit(users) {
    $.ajax({
        type: "post",
        url: "<?= site_url() ?>Users/updateData",
        data: {
            code: users,
        },
        dataType: "json",
        success: function(response) {

            if (response.data) {
                $('.updateUsers').html(response.data).show();
                $('#updateUsers').modal('show');

            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + '\n' + thrownError);
        }
    });
}
$(document).ready(function() {
    $('#table1').DataTable();

    $('.chStatus').change(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "<?= site_url() ?>Users/UpdateStatus",
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

    $('.tambahData').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('/Users/modalTambah'); ?>",
            // dataType: "json",
            success: function(response) {
                $('.tambahUser').html(response).show();
                $('#tambahUser').on('show.bs.modal', function(event) {
                    $('#users').focus();
                })
                $('#tambahUser').modal('show');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + '\n' + thrownError);
            }
        });
    });

});

function hapusUser(iduser) {
    Swal.fire({
        title: 'Hapus Users',
        text: "Yakin untuk hapus User ini ? ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya, Hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= site_url('/Users/deleteUser'); ?>",
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
                                    '<?= site_url() ?>/Users/index ');
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
</script>

<?= $this->endsection('isi'); ?>