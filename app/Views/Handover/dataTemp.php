<!-- DataTables -->
<link rel="stylesheet" href="<?= site_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= site_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- DataTables  & Plugins -->
<script src="<?= site_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<!-- <script src="<?= site_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= site_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= site_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script> -->

<div class="col-md-12">
    <table id="table1" class="table table-sm table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Order Id</th>
                <th>Driver</th>
                <th>Nama Penerima</th>
                <th>Alamat</th>
                <th>No Telepon</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($datatemp as $y) :
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $y->order_id ?></td>
                <td><?= $y->driver ?></td>
                <td><?= $y->nama_penerima ?></td>
                <td><?= $y->alamat ?></td>
                <td><?= $y->no_tlp ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
$(document).ready(function() {
    $('#table1').DataTable();
});
</script>