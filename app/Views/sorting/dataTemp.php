<div class="card">

    <div class="card-header bg-green">
        List Transaksi
    </div>
    <div class="card-body">

        <table id="table1" class="table table-sm table-striped table-bordered" style="width: 100%;">
            <thead>
                <th style="width: 5%;">No</th>
                <th>Order Id</th>
                <th>Nama Penerima</th>
                <th>Alamat</th>
                <th>Total Quantity</th>
                <th>Total Picking</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                <?php
                $nomor = 1;
                foreach ($datatemp as $row) :
                ?>
                <tr>
                    <td><?= $nomor++; ?></td>
                    <td><?= $row->Order_id; ?></td>
                    <td><?= $row->Drop_name; ?></td>
                    <td><?= $row->Drop_address ?></td>
                    <td><?= $row->jumlah ?></td>
                    <td>
                        <?php
                            $db = \Config\Database::connect();
                            $jumlah = $db->table('tbl_invoice')->getWhere(['status' => 4, 'Order_id ' => $row->Order_id])->getResult();

                            $total = 0;
                            foreach ($jumlah as $data) {
                                $total += $data->quantity;
                            }
                            echo $total;
                            ?>
                    </td>
                    <td>
                        <?php
                            $db = \Config\Database::connect();
                            $jumlah = $db->table('tbl_invoice')->getWhere(['status' => 4, 'Order_id ' => $row->Order_id])->getResult();
                            $total = 0;
                            foreach ($jumlah as $data) {
                                $total += $data->quantity;
                            }
                            if ($total != $row->jumlah && $row->status == 4) :
                            ?>
                        <span class="badge badge-info">On Proses</span>
                        <?php elseif ($total == $row->jumlah && $row->status == 3) : ?>
                        <a href="<?= site_url('Sorting/invoice/' . $row->Order_id) ?>"
                            class="btn btn-sm btn-success-outline" target="_blank"> <i class="fa fa-print"></i></a>
                        <?php elseif ($total != $row->jumlah && $row->status == 4) : ?>
                        <span class="badge badge-success">Packing</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<script>
$(document).ready(function() {
    $('#table1').DataTable();
});
</script>