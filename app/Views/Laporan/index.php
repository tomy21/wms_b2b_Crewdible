<?= $this->extend('Layout/layout'); ?>
<?= $this->section('judul'); ?>
<h1>Report Proses</h1>
<?= $this->endsection('judul'); ?>
<?= $this->section('subjudul'); ?>

<?= $this->endsection('subjudul'); ?>
<?= $this->section('isi'); ?>
<div class="card">
    <div class="card-header bg-green">
        Menu Transaksi
    </div>
    <div class="card-body">
        <?= form_open('Laporan/index') ?>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="">Tanggal Awal </label>
                <input type="date" class="form-control" id="noInvoice" name="tglAwalOut" value="">
            </div>
            <div class="form-group col-6">
                <label for="">Tanggal Akhir</label>
                <input type="date" class="form-control" id="tglInvoice" name="tglAkhirOut" placeholder="Last name">
            </div>
            <button type="submit" class="form-group col btn btn-info mt-3">Tampilkan Data</button>
        </div>
        <?= form_close(); ?>

    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Report Data</h3><br>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <table id="tabel1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Order Id</th>
                    <th>Total Quantity</th>
                    <th>Warehouse</th>
                    <th>Selisih Qty</th>
                    <th>Slot Cut OFF</th>
                    <th>Finish Packing</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($data->getResult() as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->Order_id ?></td>
                    <td>
                        <?php
                            $db = \Config\Database::connect();
                            $jumlah = $db->table('tbl_invoice')->selectSum('quantity')->where(['Order_id' => $row->Order_id])->get()->getRow();

                            echo $jumlah->quantity;
                            ?>
                    </td>
                    <td><?= $row->stock_location ?></td>
                    <td><?php
                            $db = \Config\Database::connect();
                            $jumlah = $db->table('tbl_invoice')->selectSum('quantity')->where(['Order_id' => $row->Order_id])->get()->getRow();
                            $packing = $db->table('tbl_packing')->where(['Order_id' => $row->Order_id])->get()->getResultArray();
                            $quantity = 0;
                            foreach ($packing as $x) {
                                foreach (json_decode($x['list']) as $y) {
                                    $quantity += intval($y->quantity);
                                }
                            }
                            echo $quantity - $jumlah->quantity
                            ?></td>
                    <td><?= $row->created_at ?></td>
                    <td>
                        <?php
                            $db = \Config\Database::connect();
                            $packing = $db->table('tbl_packing')->where(['Order_id' => $row->Order_id])->get()->getRow();

                            echo $packing->updated_at;
                            ?></td>
                    </td>
                    <td>
                        <?php
                            $db = \Config\Database::connect();
                            $packing = $db->table('tbl_packing')->where(['Order_id' => $row->Order_id])->get()->getRow();
                            if ($row->created_at < $packing->updated_at) :
                            ?>
                        <span class="badge badge-danger">Late</span>
                        <?php else : ?>
                        <span class="badge badge-success">Meet</span>
                        <?php endif; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Order Id</th>
                    <th>Total Quantity</th>
                    <th>Warehouse</th>
                    <th>Selisih Qty</th>
                    <th>Slot Cut OFF</th>
                    <th>Finish Packing</th>
                    <th>Status</th>
                </tr>
            </tfoot>

        </table>
    </div>
</div>
<script>
$(function() {
    $("#tabel1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#report1 .col-md-6:eq(0)');
});
</script>
<?= $this->endsection('isi'); ?>