<div class="card">

    <div class="card-header bg-green">
        List Transaksi
    </div>
    <div class="card-body">

        <table id="table1" class="table table-sm table-striped table-bordered" style="width: 100%;">
            <thead>
                <th style="width: 5%;">No</th>
                <th>Order Id</th>
                <th>Item Id</th>
                <th>Item Detail</th>
                <th>Total Item</th>
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
                    <td>
                        <?php
                            $db = \Config\Database::connect();
                            $jumlah = $db->table('tbl_invoice')->getWhere(['Order_id' => $row->Order_id])->getResult();
                            foreach ($jumlah as $data) :
                            ?>
                        <li><?= $data->Item_id ?></li>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php
                            $db = \Config\Database::connect();
                            $jumlah = $db->table('tbl_invoice')->getWhere(['Order_id' => $row->Order_id])->getResult();
                            foreach ($jumlah as $data) :
                            ?>
                        <li><?= $data->Item_detail ?></li>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <?php
                            $db = \Config\Database::connect();
                            $jumlah = $db->table('tbl_invoice')->getWhere(['Order_id' => $row->Order_id])->getResult();
                            foreach ($jumlah as $data) :
                            ?>
                        <li><?= $data->quantity ?></li>
                        <?php endforeach; ?>
                    </td>
                    <td><?= $row->jumlah ?></td>
                    <td>
                        <?php
                            $db = \Config\Database::connect();
                            $jumlah = $db->table('tbl_invoice')->getWhere(['Order_id' => $row->Order_id])->getResult();

                            $total = 0;
                            foreach ($jumlah as $data) {
                                $total += $data->quantity;
                            }
                            if ($total != $row->jumlah) :
                            ?>
                        <span class="badge badge-info">On Proses</span>
                        <?php elseif ($total == $row->jumlah) : ?>
                        <a href="<?= site_url('Sorting/invoice/' . $row->Order_id) ?>"
                            class="btn btn-sm btn-success-outline" target="_blank"> <i class="fa fa-print"></i></a>
                        <?php elseif ($row->status == 5) : ?>
                        <span class="badge badge-success">Done</span>
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