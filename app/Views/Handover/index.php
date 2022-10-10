<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Handover</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>

<div class="card">
    <div class="card-header bg-green">
        <button class="btn btn-sm btn-info" type="button"
            onclick="location.href=('<?= site_url('/Handover/buatManifest') ?>')">
            <i class="fa fa-plus"></i>
            Tambah Data</button>
    </div>
    <div class="card-body">

        <table id="table1" class="table table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Handover</th>
                    <th>List Order</th>
                    <th>Driver</th>
                    <th>Foto</th>
                    <th>Tanda Tangan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($data as $row) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['id_handover']; ?></td>
                    <td><?php
                            foreach (json_decode($row['listItem']) as $k) :
                            ?>
                        <ul>
                            <li><?= $k->order_id ?></li>
                        </ul>
                        <?php endforeach; ?>
                    </td>
                    <td><?= $row['driver'] ?></td>
                    <td><img src="<?= base_url() ?>/assets/uploades/<?= $row['foto'] ?>" alt="" width="50"></td>
                    <td>
                        <img src="<?= base_url() ?>/assets/uploades/<?= $row['tandatangan'] ?>" alt="" width="50">
                    </td>
                    <td>
                        <?php if ($row['status'] == 1) : ?>
                        <span class="badge badge-success">Done</span>
                        <?php else : ?>
                        <span class="badge badge-danger">Proses</span>
                        <?php endif; ?>
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
<div class="manifest" style="display: none;"></div>

<script>
function play_notif() {
    var audio = document.createElement('audio');
    audio.setAttribute('src', '<?= site_url() ?>/dist/img/success.mp3');
    audio.setAttribute('autoplay', 'autoplay');
    audio.play();
    audio.load();
}

function kosong() {
    $('#orderId').val('');
    $('#orderId').focus();
}


$(document).ready(function() {
    $('#table1').DataTable();
    kosong();
    $('#tombolcariIn').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url() ?>/Handover/buatManifest",
            dataType: "json",
            success: function(response) {
                if (response.data) {
                    $('.manifest').html(response.data).show();
                    $('#manifest').modal('show');
                    kosong();

                }
            }
        });
    });

});
</script>
<?= $this->endsection('isi'); ?>