<?= $this->extend('layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Packing Proses</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <p>
                <span class="badge badge-info">Transaksi Baru</span>
                <span class="badge badge-warning">Proses Picking</span>
                <span class="badge badge-dark">On Packing</span>
                <span class="badge badge-danger">Return</span>
                <span class="badge badge-secondary">Assignment Proses</span>
                <span class="badge badge-success">Done</span>
            </p>
            <table id="viewStatus" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Order id</th>
                        <th>Total Item</th>
                        <th>Foto</th>
                        <th>Assign</th>
                        <th>Status</th>
                        <th>Tanggal Proses</th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($datatemp as $query) :
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $query['order_id'] ?></td>
                        <td>
                            <?php foreach (json_decode($query['list'], true) as $data) : ?>
                            <?= $data['Item_id'] ?>
                            <?php endforeach; ?>
                        </td>
                        <td><img src="<?= base_url() ?>/assets/uploades/<?= $query['foto'] ?>" alt="" width="50"></td>
                        <td><?= $query['assign'] ?></td>
                        <td>
                            <?php if ($query['Status'] == 1) : ?>
                            <span class="badge badge-success">Done</span>
                            <?php else : ?>
                            <span class="badge badge-danger">Proses</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $query['updated_at'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="viewmodal" style="display: none;"></div>

<script>
function edit(orderId) {
    window.location.href = ('/Packing/edit/') + orderId;
}
$(document).ready(function() {
    $('#viewStatus').DataTable();
});

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

$('#btnPicking').click(function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Proses Picking',
        text: "Yakin Submit sekarang ? ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proses Sekarang !'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/picking/ProsesPick",
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Berhasil',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        play_notif();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });
        }
    });
});
</script>

<?= $this->endsection('isi'); ?>