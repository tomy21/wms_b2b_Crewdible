<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Management Users</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<div class="card">
    <div class="card-header bg-green">
        User Management
    </div>
    <div class="card-body">
        <p>
            <button class="btn btn-info tambahData" type="submit" id="tambahData">
                <i class=" fa fa-plus"> Tambah Karyawan</i>
            </button>
        </p>
        <table id="table1" class="table table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Karyawan</th>
                    <th>Nama Karyawan</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data->getResultArray() as $row) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['id_user']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['level'] ?></td>
                    <td>
                        <?php if ($row['status'] == 1) : ?>
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
<div class="tambahUser" style="display: none;"></div>
<div class="updateUser" style="display: none;"></div>

<script>
$(document).ready(function() {
    $('#table1').DataTable();

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
</script>

<?= $this->endsection('isi'); ?>