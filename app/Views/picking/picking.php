<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Picking Proses</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">

            <table id="viewStatus" class="table table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Basket</th>
                        <th>Assign</th>
                        <th>Item id</th>
                        <th>Item detail</th>
                        <th>Quantity</th>
                        <th>Quantity Picking</th>
                        <th>Status</th>
                        <th>Tanggal Proses</th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($data as $query) :
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $query['id_basket'] ?></td>
                        <td><?= $query['assign'] ?></td>
                        <td><?= $query['Item_id'] ?></td>
                        <td><?= $query['Item_detail'] ?></td>
                        <td><?= $query['qty'] ?></td>
                        <td><?= $query['quantity_pick'] ?></td>

                        <td>
                            <?php if ($query['status'] == 1) : ?>
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
function edit(assign) {
    window.location.href = ('/Picking/edit/') + assign;
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